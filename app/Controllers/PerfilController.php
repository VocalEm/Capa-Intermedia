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
         *             },
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
        if ($usuario) {
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
        } else
            require_once '../app/views/home.php';
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

    public function eliminarPerfil()
    {
        UsuarioSesion::iniciar();
        // Siempre elimina la cookie `TOKEN`
        $usuarioId = UsuarioSesion::id();
        $usuarioModel = new Usuario();
        $tarea = $usuarioModel->desctivarUsuario($usuarioId);
        if ($tarea) {
            UsuarioSesion::cerrar();
            header('Location: /');
            exit;
        } else {
            $_SESSION['errores'] = 'Error al eliminar el perfil.';
            header('Location: /perfil');
            exit;
        }
    }

    public function mostrarEditarPerfil()
    {
        $usuarioId = UsuarioSesion::id();
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorId($usuarioId);

        if ($usuario) {
            $title = "Editar Perfil";
            require_once '../app/views/editar_perfil.php';
        } else {
            header('Location: /home');
            exit;
        }
    }

    public function editarPerfil()
    {
        UsuarioSesion::iniciar();
        $usuarioId = UsuarioSesion::id();
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorId($usuarioId);

        if (!$usuario) {
            header('Location: /home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = [];

            // Solo los campos editables
            $datos = [
                'NOMBRE' => trim($_POST['NOMBRE'] ?? ''),
                'APELLIDO_P' => trim($_POST['APELLIDO_P'] ?? ''),
                'APELLIDO_M' => trim($_POST['APELLIDO_M'] ?? ''),
                'CORREO' => strtolower(trim($_POST['CORREO'] ?? '')),
                'USERNAME' => strtolower(trim($_POST['USERNAME'] ?? '')),
                'PRIVACIDAD' => $_POST['PRIVACIDAD'] ?? $usuario['PRIVACIDAD'],
                'SEXO' => $_POST['SEXO'] ?? $usuario['SEXO'],
                'IMAGEN' => $_FILES['IMAGEN'] ?? null,
                'PASSW' => $_POST['PASSW'] ?? ''
            ];

            // Validaciones básicas
            if (empty($datos['NOMBRE'])) $errores[] = "El nombre es obligatorio.";
            if (empty($datos['APELLIDO_P'])) $errores[] = "El apellido paterno es obligatorio.";
            if (empty($datos['APELLIDO_M'])) $errores[] = "El apellido materno es obligatorio.";
            if (empty($datos['CORREO']) || !filter_var($datos['CORREO'], FILTER_VALIDATE_EMAIL)) $errores[] = "Correo inválido.";
            if (empty($datos['USERNAME'])) $errores[] = "El nombre de usuario es obligatorio.";
            if (empty($datos['SEXO']) || !in_array($datos['SEXO'], ['M', 'F'])) $errores[] = "Sexo inválido.";
            if (!in_array($datos['PRIVACIDAD'], ['0', '1'])) $errores[] = "Privacidad inválida.";

            // Validar duplicados (correo y username, pero solo si cambiaron)
            if ($datos['CORREO'] !== $usuario['CORREO'] && $usuarioModel->encontrarPorCorreoONickname($datos['CORREO'])) {
                $errores[] = "El correo ya está registrado.";
            }
            if ($datos['USERNAME'] !== $usuario['USERNAME'] && $usuarioModel->encontrarPorCorreoONickname($datos['USERNAME'])) {
                $errores[] = "El nombre de usuario ya está registrado.";
            }
            if (
                filter_var($datos['USERNAME'], FILTER_VALIDATE_EMAIL) ||
                strpos($datos['USERNAME'], '@') !== false ||
                strpos($datos['USERNAME'], '.') !== false ||
                preg_match('/[^a-zA-Z0-9_]/', $datos['USERNAME']) || // Solo letras, números y guion bajo
                preg_match('/\s/', $datos['USERNAME']) // No espacios
            ) {
                $errores[] = "El nombre de usuario solo puede contener letras, números y guion bajo, sin espacios ni caracteres especiales.";
            }

            // Si hay errores, mostrar la vista con errores
            if ($errores) {
                $title = "Editar Perfil";
                $usuario = array_merge($usuario, $datos); // para repoblar el formulario
                require_once '../app/views/editar_perfil.php';
                return;
            }

            // Procesar imagen solo si se subió una nueva
            if ($datos['IMAGEN'] && $datos['IMAGEN']['error'] === UPLOAD_ERR_OK) {
                $datos['IMAGEN'] = $this->guardarImagen($datos['IMAGEN']);
            } else {
                unset($datos['IMAGEN']); // No actualizar si no hay nueva imagen
            }

            // Procesar contraseña solo si se proporcionó una nueva
            if (!empty($datos['PASSW'])) {
                $datos['PASSW'] = password_hash($datos['PASSW'], PASSWORD_DEFAULT);
            } else {
                unset($datos['PASSW']); // No actualizar si no hay nueva contraseña
            }

            // Actualizar usuario
            $actualizado = $usuarioModel->actualizarPerfil($usuarioId, $datos);

            if ($actualizado) {
                $_SESSION['exito'] = "Perfil actualizado correctamente.";
                header('Location: /perfil');
                exit;
            } else {
                $errores[] = "Error al actualizar el perfil.";
                $title = "Editar Perfil";
                require_once '../app/views/editar_perfil.php';
            }
        } else {
            header('Location: /perfil');
            exit;
        }
    }
}
