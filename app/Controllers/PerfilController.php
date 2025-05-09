<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;
use App\Models\Lista;

class PerfilController
{

    public function usuarioSesion()
    {
        $idUsuario = UsuarioSesion::obtener();
        $usuario = new Usuario();
        $usuario = $usuario->obtenerPorId($idUsuario['id']);
        $listaModel = new Lista();

        // Obtener las listas y sus productos mediante un JOIN
        $datos = $listaModel->obtenerListasConProductos($idUsuario['id']);

        /**
         * `datos` es un arreglo donde cada fila contiene información tanto de la lista 
         * como de los productos. 
         * Debemos organizarlo para que todos los productos de una lista queden agrupados 
         * bajo la misma lista.
         */

        $listasConProductos = [];

        foreach ($datos as $fila) {
            $listaId = $fila['lista_id'];

            // Si la lista aún no ha sido agregada al arreglo, la inicializamos
            if (!isset($listasConProductos[$listaId])) {
                $listasConProductos[$listaId] = [
                    'ID' => $listaId,
                    'NOMBRE' => $fila['lista_nombre'],
                    'DESCRIPCION' => $fila['lista_descripcion'],
                    'PRIVACIDAD' => $fila['lista_privacidad'],
                    'IMAGEN' => $fila['lista_imagen'],
                    'productos' => []  // Inicializamos el arreglo de productos
                ];
            }

            /**
             * Si `ID_PRODUCTO` no es nulo, significa que la lista tiene al menos un producto asociado.
             * Esto previene que listas vacías no tengan el índice `productos`.
             */
            if ($fila['ID_PRODUCTO']) {
                $listasConProductos[$listaId]['productos'][] = [
                    'ID' => $fila['ID_PRODUCTO'],
                    'NOMBRE' => $fila['producto_nombre'],
                    'PRECIO' => $fila['producto_precio'],
                    'IMAGEN' => $fila['producto_imagen']
                ];
            }
        }

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


    /**
     * Maneja la subida de imagenes para listas.
     * Retorna el nombre del archivo o 'default.jpg' si no hay imagen.
     */
    private function guardarImagen($archivo)
    {
        if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid() . '_' . $archivo['name'];
            $ruta = '../app/uploads/' . $nombreArchivo;

            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                return $nombreArchivo;
            }
        }

        return 'default.jpg';
    }
}
