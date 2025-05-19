<?php

namespace App\Controllers;

use App\Models\Pago;
use App\Helpers\UsuarioSesion;
use App\Models\Carrito;
use App\Models\Producto;

class PagoController
{
    public function mostrarPago()
    {
        $total = isset($_GET['total']) ? floatval($_GET['total']) : 0;

        if ($total <= 0) {
            $_SESSION['errores'] = "Monto de pago inválido.";
            header('Location: /carrito');
            exit;
        }

        require_once '../app/views/pago.php';
    }

    public function procesarPago()
    {
        session_start();
        $idUsuario = UsuarioSesion::id();
        $productoModel = new Producto();
        $pagoModel = new Pago();
        $carritoModel = new Carrito();

        // Validación del formulario
        $nombre = trim($_POST['nombre']);
        $direccion = trim($_POST['direccion']);
        $numeroTarjeta = trim($_POST['numero_tarjeta']);
        $mes = trim($_POST['mes']);
        $year = trim($_POST['year']);
        $cvv = trim($_POST['cvv']);

        if (empty($nombre) || empty($direccion) || empty($numeroTarjeta) || empty($mes) || empty($year) || empty($cvv)) {
            $_SESSION['errores'] = "Todos los campos son obligatorios.";
            header('Location: /pago');
            exit;
        }

        if (!preg_match('/^\d{16}$/', $numeroTarjeta)) {
            $_SESSION['errores'] = "Número de tarjeta inválido.";
            header('Location: /pago');
            exit;
        }

        if (!preg_match('/^\d{2}$/', $mes) || !preg_match('/^\d{2}$/', $year)) {
            $_SESSION['errores'] = "Fecha de expiración inválida.";
            header('Location: /pago');
            exit;
        }

        if (!preg_match('/^\d{3}$/', $cvv)) {
            $_SESSION['errores'] = "CVV inválido.";
            header('Location: /pago');
            exit;
        }

        // Validar productos en el carrito
        $productos = $productoModel->mostrarProductosPorCarrito($idUsuario);

        if (empty($productos)) {
            $_SESSION['errores'] = "El carrito está vacío.";
            header('Location: /carrito');
            exit;
        }

        // Calcular total
        $subtotal = 0;
        foreach ($productos as $producto) {
            if ($producto['PRECIO'] == 0) {
                $producto['PRECIO'] = $producto['PRECIO_COTIZACION'];
            }
            $subtotal += $producto['PRECIO'] * $producto['CANTIDAD'];
        }

        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        // Crear la orden
        $ordenId = $pagoModel->crearOrden($idUsuario, $total);

        if (!$ordenId) {
            $_SESSION['errores'] = "Error al crear la orden.";
            header('Location: /pago');
            exit;
        }

        // Crear los detalles de la orden
        $detalleExitoso = $pagoModel->crearDetallesOrden($ordenId, $productos);

        if (!$detalleExitoso) {
            $_SESSION['errores'] = "Error al crear los detalles de la orden.";
            header('Location: /pago');
            exit;
        }

        // Actualizar stock de los productos
        foreach ($productos as $producto) {
            if ($producto['TIPO_PUBLICACION'] == 'venta') {
                $nuevoStock = $producto['STOCK'] - $producto['CANTIDAD'];

                if ($nuevoStock < 0) {
                    $_SESSION['errores'] = "El producto " . $producto['NOMBRE'] . " no tiene suficiente stock.";
                    header('Location: /pago');
                    exit;
                }

                $stockActualizado = $productoModel->actualizarStock($producto['ID'], $nuevoStock);

                if (!$stockActualizado) {
                    $_SESSION['errores'] = "Error al actualizar el stock del producto " . $producto['NOMBRE'];
                    header('Location: /pago');
                    exit;
                }
            }
        }


        // Vaciar el carrito después del pago exitoso
        $vaciarCarrito = $carritoModel->vaciarCarrito($idUsuario);

        if (!$vaciarCarrito) {
            $_SESSION['errores'] = "Error al vaciar el carrito después del pago.";
            header('Location: /pago');
            exit;
        }

        $_SESSION['exito'] = "Pago realizado con éxito. Orden ID: " . $ordenId;
        header('Location: /home');
        exit;
    }
}
