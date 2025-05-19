<?php

namespace App\Controllers;

use App\Models\Producto;
use App\Models\Categoria;

class CatalogoController
{
    public function mostrarCatalogo()
    {
        $productoModel = new Producto();
        $productos = $productoModel->mostrarProductos();
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->obtenerCategorias();
        $title = "BUYLY Catalogo";
        require_once '../app/Views/catalogo.php';
    }

    public function mostrarPorFiltros()
    {
        if (isset($_GET['nombre']) && $_GET['nombre'] !== '') {
            $nombre = $_GET['nombre'];
            if (!empty($nombre)) {
                // Aquí puedes continuar con la lógica para procesar las categorías
                // Por ejemplo:
                $productoModel = new Producto();
                $productos = $productoModel->mostrarProductosNombre($nombre);
                $categoriaModel = new Categoria();
                $categorias = $categoriaModel->obtenerCategorias();
                require_once '../app/Views/catalogo.php';
            } else {
                echo "No se seleccionaron categorías.";
            }
        } else if ((isset($_GET['descripcion']) && $_GET['descripcion'] !== '') && (isset($_GET['categorias']) && $_GET['descripcion'] !== '')) {
            $descripcion = $_GET['descripcion'];
            $categoriasGet = $_GET['categorias'];
            if (!empty($descripcion) && !empty($categoriasGet)) {

                $productoModel = new Producto();
                $productos = $productoModel->mostrarProductosDescripcionCategoria($descripcion, $categoriasGet);
                $categoriaModel = new Categoria();
                $categorias = $categoriaModel->obtenerCategorias();
                require_once '../app/Views/catalogo.php';
            } else {
                echo "No se seleccionaron categorías.";
            }
        } else if (isset($_GET['descripcion']) &&  $_GET['descripcion'] !== '') {
            $descripcion = $_GET['descripcion'];
            if (!empty($descripcion)) {
                // Aquí puedes continuar con la lógica para procesar las categorías
                // Por ejemplo:
                $productoModel = new Producto();
                $productos = $productoModel->mostrarProductosDescripcion($descripcion);
                $categoriaModel = new Categoria();
                $categorias = $categoriaModel->obtenerCategorias();
                require_once '../app/Views/catalogo.php';
            } else {
                echo "No se seleccionaron categorías.";
            }
        } else  if (isset($_GET['categorias'])) {
            $categoriasPost = $_GET['categorias'];
            if (!empty($categoriasPost)) {
                $categoriasData = $_GET['categorias'];
                // Aquí puedes continuar con la lógica para procesar las categorías
                // Por ejemplo:
                $productoModel = new Producto();
                $productos = $productoModel->mostrarProductosCategorias($categoriasData);
                $categoriaModel = new Categoria();
                $categorias = $categoriaModel->obtenerCategorias();
                require_once '../app/Views/catalogo.php';
            } else {
                echo "No se seleccionaron categorías.";
            }
        } else
            header('Location: /catalogo');
    }
}
