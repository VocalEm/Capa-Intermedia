<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Categoria;
use App\Models\Usuario;

class BuscarUsuarioController
{
    public function mostrarBusqueda()
    {
        require_once '../app/Views/buscarUsuarios.php';
    }

    public function buscarUsuarios()
    {
        $username = $_GET['username'] ?? null;
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->buscarUsuarios($username);
        if (empty($usuarios)) {
            $_SESSION['errores'] = 'No se encontraron resultados para la búsqueda.';
            header('Location: /buscar');
            exit;
        }

        require_once '../app/Views/buscarUsuarios.php';
    }
}

// hay que revisar las validaciones con el rol