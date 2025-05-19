<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Categoria;

class BuscarUsuarioController
{
    public function mostrarBusqueda()
    {
        require_once '../app/Views/buscarUsuarios.php';
    }
}

// hay que revisar las validaciones con el rol