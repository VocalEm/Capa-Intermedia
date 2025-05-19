<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Usuario;
use App\Models\Lista;
use App\Models\Producto;

class ListaDetalleController
{
    public function mostrarListasDetalle($idLista)
    {
        $productoModel = new Producto();
        $listaModel = new Lista();
        $lista = $listaModel->obtenerListasPorId($idLista);
        $productos = $productoModel->mostrarProductosPorLista($idLista);
        require_once '../app/views/listasDetalle.php';
    }

    public function eliminarProducto($idLista, $idProducto)
    {
        $listaModel = new Lista();
        $tarea = $listaModel->eliminarProductoDeLista($idLista, $idProducto);
        if ($tarea) {
            $_SESSION['exito'] = "Producto eliminado con exito";
            header('Location: /lista/' . $idLista);
            exit;
        } else {
            $_SESSION['errores'] = "Ocurrio un error con la eliminacion del producto";
            header('Location: /lista/' . $idLista);
            exit;
        }
    }
}
