<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Helpers\ValidadorRegistro;
use App\Helpers\UsuarioSesion;

class InicioSesionController
{
    public function index()
    {
        $title = 'BUYLY';
        require_once '../app/views/landing.php';
    }

    public function mostrarInicioSesion()
    {
        UsuarioSesion::iniciar();
        $title = 'Iniciar Sesión';
        require_once '../app/views/inicioSesion.php';
    }

    public function login()
    {
        $title = 'Iniciar Sesión';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['loginEmail'] ?? '';
            $contrasena = $_POST['loginPassword'] ?? '';
            $recordar = isset($_POST['recordar']) ? true : false;

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->encontrarPorCorreoONickname($correo);

            if ($usuario && password_verify($contrasena, $usuario['PASSW'])) {
                UsuarioSesion::iniciar();

                // Crear la sesión
                $_SESSION['usuario'] = [
                    'id' => $usuario['ID'],
                    'username' => $usuario['USERNAME'],
                    'rol' => $usuario['ROL']
                ];

                // Si marcó "Recordarme", generamos el token
                if ($recordar) {
                    $token = bin2hex(random_bytes(32)); // Generar un token seguro
                    setcookie('TOKEN', $token, time() + (86400 * 30), "/"); // Expira en 30 días

                    // Guardar el token en la base de datos
                    $usuarioModel->actualizarToken($usuario['ID'], $token);
                }

                header('Location: /home');
                exit;
            } else {
                $erroresLogin = "Correo, usuario o contraseña incorrectos.";
            }

            require_once '../app/views/inicioSesion.php';
        }
    }


    public function registrar()
    {
        $title = 'Iniciar Sesión';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = [];
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'apellido_p' => $_POST['apellido_p'] ?? '',
                'apellido_m' => $_POST['apellido_m'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'correo' => strtolower(trim($_POST['email'])) ?? '', // Convertir a minúsculas y eliminar espacios
                'username' => strtolower(trim($_POST['username'])) ?? '',
                'password' => $_POST['password'] ?? '',
                'rol' => $_POST['rol'] ?? 'comprador',
                'privacidad' => $_POST['privacidad'] ?? 1,
                'fecha_nacimiento' => $_POST['fechaNacimiento'] ?? '',
                'avatar' => $_FILES['avatar'] ?? null
            ];

            // Validaciones
            $errores = ValidadorRegistro::validar($datos, $datos['avatar']);

            // Validar duplicados
            $usuarioModel = new Usuario();
            if ($usuarioModel->encontrarPorCorreoONickname($datos['correo'])) {
                $errores['correo'] = "El correo ya está registrado.";
            }
            if ($usuarioModel->encontrarPorCorreoONickname($datos['username'])) {
                $errores['username'] = "El nombre de usuario ya está registrado.";
            }

            if (!$errores) {
                $datos['passw'] = password_hash($datos['password'], PASSWORD_DEFAULT);
                $datos['imagen'] = $this->guardarAvatar($datos['avatar']);
                $registrado = $usuarioModel->registrar($datos);

                if ($registrado) {
                    UsuarioSesion::iniciar();
                    $_SESSION['exito'] = "Registro exitoso. Ya puedes iniciar sesión.";
                    header('Location: /inicio_sesion');
                    exit;
                }
            }

            require_once '../app/views/inicioSesion.php';
        }
    }


    private function guardarAvatar($archivo)
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

// hay que revisar las validaciones con el rol