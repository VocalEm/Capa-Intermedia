<?php

namespace App\Controllers;

class CatalogoController
{
    public function mostrarCatalogo()
    {
        $title = "BUYLY Catalogo";
        require_once '../app/Views/catalogo.php';
    }
}
