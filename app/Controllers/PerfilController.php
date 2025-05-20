<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;
use App\Models\Lista;
use App\Models\Producto;

class PerfilController
{

    public function mostrarPerfilUsuarioSesion()
    {
        $usuarioId = UsuarioSesion::id();
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorId($usuarioId);

        if ($usuario['ROL'] == 'comprador') {
            $listaModel = new Lista();
            $listas = $listaModel->obtenerListasPorUsuario($usuario['ID']);
        } else if ($usuario['ROL'] == 'vendedor') {
            $productoModel = new Producto();
            $productos = $productoModel->mostrarProductosVendedor($usuario['ID']);
        } else if ($usuario['ROL'] == 'administrador') {
            $productoModel = new Producto();
            $rechazados = $productoModel->obtenerProductosRechazadosPorAdmin($usuario['ID']);
            $autorizados = $productoModel->obtenerProductosAutorizadosPorAdmin($usuario['ID']);
        }
        $miPerfil = true;
        /**
         * En este punto, `listasConProductos` es un arreglo estructurado de la siguiente forma:
         *
         * [
         *     1 => [
         *         'ID' => 1,
         *         'NOMBRE' => 'Lista 1',
         *         'DESCRIPCION' => 'Lista de compras',
         *         'PRIVACIDAD' => 1,
         *         'productos' => [
         *             [
         *                 'ID' => 1,
         *                 'NOMBRE' => 'Producto 1',
         *                 'PRECIO' => 500,
         *                 'IMAGEN' => 'producto1.jpg'
         *             ],
         *             [
         *                 'ID' => 2,
         *                 'NOMBRE' => 'Producto 2',
         *                 'PRECIO' => 300,
         *                 'IMAGEN' => 'producto2.jpg'
         *             ]
         *         ]
         *     ],
         *     2 => [
         *         'ID' => 2,
         *         'NOMBRE' => 'Lista 2',
         *         'DESCRIPCION' => 'Regalos',
         *         'PRIVACIDAD' => 0,
         *         'productos' => []
         *     ]
         * ]
         */

        $title = $usuario['USERNAME'];
        require_once '../app/views/perfil.php';
    }

    public function mostrarPerfilUsuario($idUsuario)
    {
        if ($idUsuario == UsuarioSesion::obtener()['id']) {
            header('Location: /perfil');
            exit;
        }

        $usuario = new Usuario();
        $usuario = $usuario->obtenerPorId($idUsuario);


        if ($usuario['ROL'] == 'comprador') {
            $listaModel = new Lista();
            $listas = $listaModel->obtenerListasPorUsuario($idUsuario);
        } else if ($usuario['ROL'] == 'vendedor') {
            $productoModel = new Producto();
            $productos = $productoModel->mostrarProductosVendedor($idUsuario);
        }
        $miPerfil = false;

        $title = $usuario['USERNAME'];
        require_once '../app/views/perfil.php';
    }

    public function mostrarPerfil()
    {
        // Verificar si el usuario está autenticado
        $idUsuario = UsuarioSesion::obtener();

        if (!$idUsuario) {
            // Si no está autenticado, lo redirigimos al login
            header('Location: /login');
            exit;
        }

        // Instanciar el modelo Lista para acceder a los métodos de base de datos


        // Título de la página
        $title = "Perfil";

        // Cargar la vista del perfil y pasarle las listas organizadas
        require_once '../app/views/perfil.php';
    }

    public function crearLista()
    {
        $idUsuario = UsuarioSesion::obtener();

        if (!$idUsuario) {
            header('Location: /home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $privacidad = ($_POST['privacidad'] === 'publica') ? 1 : 0;
            $imagen = $this->guardarImagen($_FILES['imagen']);

            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'privacidad' => $privacidad,
                'idUsuario' => $idUsuario['id']
            ];

            $listaModel = new Lista();

            if ($listaModel->crearLista($datos)) {
                header('Location: /perfil');
                $_SESSION['exito'] = 'Lista creada exitosamente.';
                exit;
            } else {
                echo "Error al crear la lista.";
            }
        } else {
            header('Location: /home');
            exit;
        }
    }

    public function eliminarLista($idLista)
    {
        $idUsuario = UsuarioSesion::obtener();

        if (!$idUsuario) {
            header('Location: /login');
            exit;
        }

        $listaModel = new Lista();

        $datos = [
            'idLista' => $idLista,
            'idUsuario' => $idUsuario['id']
        ];

        if ($listaModel->eliminarLista($datos)) {
            $_SESSION['exito'] = 'Lista eliminada exitosamente.';
            header('Location: /perfil');
            exit;
        } else {
            echo "Error al eliminar la lista.";
        }
    }

    private function guardarImagen($archivo)
    {
        if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {

            // Nombre original del archivo
            $nombreOriginal = $archivo['name'];

            // Reemplazar espacios por guiones bajos
            $nombreLimpio = preg_replace('/\s+/', '_', $nombreOriginal);

            // Remover caracteres especiales dejando solo letras, números, guiones bajos, puntos y guiones
            $nombreLimpio = preg_replace('/[^A-Za-z0-9_.-]/', '', $nombreLimpio);

            // Generar un nombre único
            $nombreArchivo = uniqid() . '_' . $nombreLimpio;

            // Ruta final donde se guardará el archivo
            $ruta = '../app/uploads/' . $nombreArchivo;

            // Mover el archivo
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                return $nombreArchivo;
            }
        }

        // En caso de error, retornar una imagen por defecto
        return 'default.jpg';
    }
}
