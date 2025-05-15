<?php

namespace App\Middlewares;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;

class AdminMiddleware
{
    public function handle()
    {
        UsuarioSesion::iniciar();

        if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'administrador') {
            return;
        }

        if (isset($_COOKIE['TOKEN'])) {
            $token = $_COOKIE['TOKEN'];
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->obtenerPorToken($token);

            if ($usuario && $usuario['ROL'] === 'administrador') {
                $_SESSION['usuario'] = [
                    'id' => $usuario['ID'],
                    'username' => $usuario['USERNAME'],
                    'rol' => $usuario['ROL']
                ];
                return;
            }
        }

        header('Location: /login');
        exit;
    }
}
