<?php

namespace App\Controllers;

use App\Models\Usuario;

class InicioSesionController
{
    public function index()
    {
        require_once '../app/views/landing.php';
    }

    public function mostrarInicioSesion()
    {
        require_once '../app/views/inicioSesion.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['loginEmail'] ?? '';
            $contrasena = $_POST['loginPassword'] ?? '';

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->encontrarPorCorreoONickname($correo);

            if ($usuario && password_verify($contrasena, $usuario['PASSW'])) {
                session_start();
                $_SESSION['usuario'] = [
                    'id' => $usuario['ID'],
                    'username' => $usuario['USERNAME'],
                    'rol' => $usuario['ROL']
                ];
                header('Location: /home');
                exit;
            } else {
                echo "Correo o contraseña incorrectos";
            }
        }
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rol = $_POST['rol'] ?? 'cliente';
            $privacidad = ($_POST['privacidad'] ?? '') === 'privado' ? 1 : 0;

            // Validar privacidad solo si el rol es "cliente"
            if ($rol !== 'cliente') {
                $privacidad = 0; // Valor predeterminado para roles distintos de cliente
            }

            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'apellido_p' => $_POST['apellido_p'] ?? '',
                'apellido_m' => $_POST['apellido_m'] ?? '',
                'sexo' => $_POST['sexo'] ?? 'otro',
                'correo' => $_POST['email'] ?? '',
                'username' => $_POST['username'] ?? '',
                'passw' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
                'rol' => $rol,
                'imagen' => $this->guardarAvatar($_FILES['avatar'] ?? null),
                'fecha_nacimiento' => $_POST['fechaNacimiento'] ?? '',
                'privacidad' => $privacidad
            ];

            $usuarioModel = new Usuario();
            $registrado = $usuarioModel->registrar($datos);

            if ($registrado) {
                header('Location: /');
                exit;
            } else {
                echo "Error al registrar el usuario.";
            }
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
