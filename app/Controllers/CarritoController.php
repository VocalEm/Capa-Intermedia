<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Carrito;
use App\Models\Producto;

class CarritoController
{
    public function mostrarCarrito()
    {
        $idUsuario = UsuarioSesion::id();
        $productoModel = new Producto();
        $productos = $productoModel->mostrarProductosPorCarrito($idUsuario);
        $title = "Carrito";
        require_once '../app/Views/carrito.php';
    }

    public function agregarProducto($idProducto)
    {

        $idUsuario = UsuarioSesion::id();
        $carritoModel = new Carrito();
        $productoModel = new Producto();

        $tarea = $carritoModel->agregarProductoCarrito($idUsuario, $idProducto);
        if ($tarea) {
            $_SESSION['exito'] = "Producto agregado con exito";
            header('Location: /catalogo');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un error con el carrito";
            header('Location: /catalogo');
            exit;
        }
    }

    public function eliminarProducto($idProducto)
    {

        $idUsuario = UsuarioSesion::id();
        $carritoModel = new Carrito();
        $tarea = $carritoModel->eliminarProductoCarrito($idUsuario, $idProducto);
        if ($tarea) {
            header('Location: /carrito');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un error con el carrito";
            header('Location: /catalogo');
            exit;
        }
    }

    public function aumentarCantidad($idProducto)
    {
        $idUsuario = UsuarioSesion::id();
        $carritoModel = new Carrito();
        $tarea = $carritoModel->aumentarCantidadProducto($idUsuario, $idProducto);
        if ($tarea) {
            header('Location: /carrito');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un error con el carrito";
            header('Location: /carrito');
            exit;
        }
    }

    public function reducirCantidad($idProducto)
    {
        $idUsuario = UsuarioSesion::id();
        $carritoModel = new Carrito();
        $tarea = $carritoModel->reducirCantidadProducto($idUsuario, $idProducto);
        if ($tarea) {
            header('Location: /carrito');
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un error con el carrito";
            header('Location: /carrito');
            exit;
        }
    }
}
