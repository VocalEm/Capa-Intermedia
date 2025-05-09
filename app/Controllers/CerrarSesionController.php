<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;

class CerrarSesionController
{
    public function cerrarSesion()
    {
        UsuarioSesion::iniciar();

        // Siempre elimina la cookie `TOKEN`
        UsuarioSesion::cerrar();

        // Redirigir al login o landing
        header('Location: /login');
        exit;
    }
}
