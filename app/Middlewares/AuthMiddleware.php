<?php

namespace App\Middlewares;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;

class AuthMiddleware
{
    public function handle()
    {
        UsuarioSesion::iniciar();

        // Si la sesión ya está activa, dejamos pasar
        if (UsuarioSesion::estaAutenticado()) {
            return;
        }

        // Si no hay sesión, verificamos la cookie `TOKEN`
        if (isset($_COOKIE['TOKEN'])) {
            $token = $_COOKIE['TOKEN'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->obtenerPorToken($token);

            if ($usuario) {
                // Restaurar la sesión a partir del token
                $_SESSION['usuario'] = [
                    'id' => $usuario['ID'],
                    'username' => $usuario['USERNAME'],
                    'rol' => $usuario['ROL']
                ];
                return;
            }
        }

        // Si no hay sesión ni cookie válida, redirigimos al login
        header('Location: /login');
        exit;
    }
}
