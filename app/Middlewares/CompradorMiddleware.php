<?php

namespace App\Middlewares;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;

class CompradorMiddleware
{
    public function handle()
    {
        UsuarioSesion::iniciar();

        if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'comprador') {
            return;
        }

        if (isset($_COOKIE['TOKEN'])) {
            $token = $_COOKIE['TOKEN'];
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->obtenerPorToken($token);

            if ($usuario && $usuario['ROL'] === 'comprador') {
                $_SESSION['usuario'] = [
                    'id' => $usuario['ID'],
                    'username' => $usuario['USERNAME'],
                    'rol' => $usuario['ROL']
                ];
                // Actualizar la cookie para extender el tiempo de expiración
                setcookie('TOKEN', $token, time() + (86400 * 30), "/"); // Extiende 30 días desde el momento de restauración
                return;
            }
        }

        header('Location: /login');
        exit;
    }
}
