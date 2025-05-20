<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Categoria;
use App\Models\Usuario;

class CategoriasController
{
    public function mostrarCategorias()
    {
        $cateogriasModel = new Categoria();
        $categorias = $cateogriasModel->obtenerCategorias();
        require_once '../app/Views/listaCategorias.php';
    }
}

// hay que revisar las validaciones con el rol