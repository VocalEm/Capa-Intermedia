<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Lista;
use App\Models\Producto;

class ProductoController
{
    public function mostrarProducto($id)
    {
        $idUsuario = UsuarioSesion::id();

        $productoModel = new Producto();
        $listasModel = new Lista();
        $productos = $productoModel->mostrarProductoPorId($id);
        $listas = $listasModel->obtenerListasPorUsuario($idUsuario);
        $producto = $productos[0];
        $title = "BUYLY Producto";
        require_once '../app/Views/producto.php';
    }


    public function productoAgregarLista($idLista, $idProducto)
    {
        $listasModel = new Lista();
        $ejecucion = $listasModel->agregarProductoALista($idLista, $idProducto);
        if ($ejecucion) {
            $_SESSION['exito'] = 'Producto agregado a la lista';
            header('Location: /perfil');
        } else {
            $_SESSION['errores'] = 'Producto ya existe en esa lista';
            header('Location: /perfil');
        }
    }

    public function mostrarEditar($idProducto)
    {
        $idUsuario = UsuarioSesion::id();

        $productoModel = new Producto();
        $productos = $productoModel->mostrarProductoPorId($idProducto);
        $producto = $productos[0];

        require_once '../app/Views/productoEditar.php';
    }

    public function actualizarProducto($idProducto)
    {
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $productoModel = new Producto();
        $producto = $productoModel->actualizarProducto($idProducto, $precio, $stock);
        if ($producto) {
            $_SESSION['exito'] = 'Producto actualizado';
            header('Location: /perfil');
        } else {
            $_SESSION['errores'] = 'Error al actualizar el producto';
            header('Location: /perfil');
        }
    }

    public function eliminarProducto($idProducto)
    {
        $productoModel = new Producto();
        $producto = $productoModel->eliminarProducto($idProducto);
        if ($producto) {
            $_SESSION['exito'] = 'Producto eliminado';
            header('Location: /perfil');
        } else {
            $_SESSION['errores'] = 'Error al eliminar el producto';
            header('Location: /perfil');
        }
    }
}
