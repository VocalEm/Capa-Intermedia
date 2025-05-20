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

        require_once '../app/views/opcionesPago.php';
    }

    public function mostrarFormularioPagoTarjeta($_total)
    {
        $total = $_total;

        require_once '../app/views/pago.php';
    }

    /*
    public function mostrarFormularioPagoEfectivo($_total)
    {
        $total = $_total;
        require_once '../app/views/pagoEfectivo.php';
    }*/

    public function descargarComprobanteEfectivo($ordenId, $total)
    {
        require_once __DIR__ . '/../../vendor/autoload.php'; // Asegúrate de tener FPDF y Barcode en composer

        $codigo = str_pad($ordenId, 10, '0', STR_PAD_LEFT);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Comprobante de Pago en Efectivo', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 10, 'Monto a pagar: $' . number_format($total, 2), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Codigo de barras:', 0, 1, 'L');

        // Generar código de barras (usando Picqer\Barcode\BarcodeGeneratorPNG)
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

        $barcodePath = sys_get_temp_dir() . "/barcode_$codigo.png";
        file_put_contents($barcodePath, $barcode);

        $pdf->Image($barcodePath, 10, 60, 100, 30);
        unlink($barcodePath);

        $pdf->Ln(40);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Lleva este comprobante a la tienda para realizar tu pago.', 0, 1, 'L');

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="comprobante_pago_efectivo.pdf"');
        $pdf->Output('D', "comprobante_pago_efectivo.pdf");
        exit;
    }

    public function mostrarFormularioPagoPaypal($_total)
    {
        $total = $_total;
        require_once '../app/views/pagoPaypal.php';
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
        header('Location: /valoracion/mostrarValoracion/' . $ordenId);
        exit;
    }

    public function procesarPagoEfectivo()
    {
        session_start();
        $idUsuario = UsuarioSesion::id();
        $productoModel = new Producto();
        $pagoModel = new Pago();
        $carritoModel = new Carrito();

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

        // Redirigir a la vista de pago en efectivo con ordenId y total
        $_SESSION['exito'] = "Pago en efectivo iniciado. Orden ID: " . $ordenId;
        header('Location: /pago/efectivo/' . $ordenId . '/' . $total);
        exit;
    }

    public function mostrarFormularioPagoEfectivo($ordenId = null, $total = null)
    {
        // Si se llama desde el flujo de pago en efectivo, recibirá ordenId y total
        if ($ordenId && $total) {
            require_once '../app/views/pagoEfectivo.php';
        } else {
            // Si solo recibe el total, mostrar formulario para iniciar pago en efectivo
            $total = $ordenId; // compatibilidad con la ruta anterior
            require_once '../app/views/pagoEfectivo.php';
        }
    }

    public function procesarPagoPaypal()
    {
        session_start();
        $idUsuario = UsuarioSesion::id();
        $productoModel = new Producto();
        $pagoModel = new Pago();
        $carritoModel = new Carrito();

        // Validar que venga el order_id de PayPal
        if (empty($_GET['paypal_order_id'])) {
            $_SESSION['errores'] = "No se recibió el ID de la orden de PayPal.";
            header('Location: /pago');
            exit;
        }
        $paypalOrderId = $_GET['paypal_order_id'];

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

        // Crear la orden (puedes guardar el paypalOrderId si tu modelo lo permite)
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

        $_SESSION['exito'] = "Pago realizado con PayPal. Orden ID: " . $ordenId;
        header('Location: /valoracion/mostrarValoracion/' . $ordenId);
        exit;
    }
}
