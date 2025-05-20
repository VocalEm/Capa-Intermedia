<?php

namespace App\Controllers;

use App\Models\Producto;
use App\Middlewares\AuthMiddleware;
use App\Models\Usuario;

class HomeController
{
    public function index()
    {
        if ($_SESSION['usuario']['rol'] == 'superadmin')
            header('Location: /superadmin/home');
        else if ($_SESSION['usuario']['rol'] == 'administrador')
            header('Location: /admin');
        else if ($_SESSION['usuario']['rol'] == 'vendedor')
            header('Location: /perfil');
        $title = 'BUYLY';
        $productoModel = new Producto();;
        $productosMayorCalifiacion = $productoModel->mostrarProductosFiltros('', [], 'cualquiera', 'mayorCalificacion');
        $productosMasVendidos = $productoModel->mostrarProductosMasVendidos(10); // top 10

        require_once '../app/views/home.php';
    }

    //administrador
    /*
    public function obtenerPendientes()
    {
        $productoModel = new Producto();
        $title = 'Productos Pendientes';
        $productos = $productoModel->mostrarProductosPendientes();
        require_once '../app/views/homeAdmin.php';
    }
*/
    public function aprobarProducto()
    {
        $productoModel = new Producto();
        $aprobado = $productoModel->aprobarProducto($_POST['producto_id']);
        if ($aprobado) {
            $_SESSION['exito'] = "Producto aceptado con exito";
            header('Location: /admin');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un problema";
            header('Location: /admin');
        }
    }

    public function rechazarProducto()
    {
        $productoModel = new Producto();
        $aprobado = $productoModel->rechazarProducto($_POST['producto_id']);
        if ($aprobado) {
            $_SESSION['exito'] = "Producto rechazado con exito";
            header('Location: /admin');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un problema";
            header('Location: /admin');
        }
    }


    public function mostrarVistaAdmin()
    {
        // Cargar la vista completa
        $title = 'Panel de Administración';
        require_once '../app/views/homeAdmin.php';
    }

    public function obtenerProductosPendientes()
    {
        $productoModel = new Producto();

        $productos = $productoModel->mostrarProductosPendientes();

        echo json_encode([
            'status' => 'success',
            'productos' => $productos,
            'timestamp' => time()
        ]);
        exit;
    }


    // admin ajax 

    /*
    public function aprobarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoModel = new Producto();
            $idProducto = $_POST['producto_id'] ?? null;

            if ($idProducto) {
                $aprobado = $productoModel->aprobarProducto($idProducto);
                if ($aprobado) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto aprobado con éxito.',
                        'idProducto' => $idProducto
                    ]);
                    exit;
                }
            }

            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo aprobar el producto.'
            ]);
            exit;
        }
    }

    public function rechazarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoModel = new Producto();
            $idProducto = $_POST['producto_id'] ?? null;

            if ($idProducto) {
                $rechazado = $productoModel->rechazarProducto($idProducto);
                if ($rechazado) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto rechazado con éxito.',
                        'idProducto' => $idProducto
                    ]);
                    exit;
                }
            }

            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo rechazar el producto.'
            ]);
            exit;
        }
    } */


    //superAdmin
    public function mostrarPanelAdministracion()
    {
        $title = 'Panel';
        $usuarioModel = new Usuario();
        $administradores = $usuarioModel->obtenerAdministradores();
        require_once  '../app/views/homeSuperAdmin.php';
    }

    public function agregarAdministrador()
    {
        $title = 'Gestion Buyly Admin';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = [];
            $datos = [
                'nombre' => "administrador",
                'apellido_p' => 'admin',
                'apellido_m' => 'buyly',
                'sexo' => 'M',
                'correo' => strtolower(trim($_POST['email'])) ?? '', // Convertir a minúsculas y eliminar espacios
                'username' => strtolower(trim($_POST['email'])) ?? '', //CHECAR QUE NO PUEDAS PONER UN CORREO ELECTRONICO COMO NOMBRE DE USUARIO
                'password' => $_POST['password'] ?? '',
                'rol' => 'administrador',
                'privacidad' => 1,
                'fecha_nacimiento' => '2000-11-11',
                'avatar' =>  null
            ];

            // Validar duplicados
            $usuarioModel = new Usuario();
            if ($usuarioModel->encontrarPorCorreoONickname($datos['correo'])) {
                $errores['correo'] = "El correo ya está registrado.";
            }
            if ($usuarioModel->encontrarPorCorreoONickname($datos['username'])) {
                $errores['username'] = "El nombre de usuario ya está registrado.";
            }

            if (!$errores) {
                $datos['passw'] = password_hash($datos['password'], PASSWORD_DEFAULT);;
                $registrado = $usuarioModel->registrar($datos);

                if ($registrado) {
                    $_SESSION['exito'] = "Administrador registrado con exito";
                    header('Location: /superadmin/home');
                    exit;
                }
            }
            $administradores = $usuarioModel->obtenerAdministradores();

            require_once '../app/views/homeSuperAdmin.php';
        }
    }

    public function eliminarAdministrador()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAdmin = $_POST['idAdmin'] ?? null;

            if ($idAdmin) {
                $usuarioModel = new Usuario();
                $eliminado = $usuarioModel->eliminarAdministrador($idAdmin);

                if ($eliminado) {
                    $_SESSION['exito'] = "Administrador eliminado con éxito.";
                } else {
                    $_SESSION['error'] = "No se pudo eliminar el administrador.";
                }
            } else {
                $_SESSION['error'] = "ID no válido.";
            }

            header('Location: /superadmin/home');
            exit;
        }
    }
}
