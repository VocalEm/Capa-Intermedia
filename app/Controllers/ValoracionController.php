<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Valoracion;
use App\Models\Producto;

class ValoracionController
{
    public function mostrarValoracion($idVenta)
    {
        $productoModel = new Producto();
        $productos = $productoModel->mostrarProductosVenta($idVenta);
        require_once '../app/views/valoracion.php';
    }

    public function valorarProductos()
    {
        $idUsuario = UsuarioSesion::id();
        $ratings = $_POST['ratings'] ?? [];

        if (empty($ratings)) {
            $_SESSION['errores'] = "No se recibieron valoraciones.";
            header('Location: /valoracion');
            exit;
        }

        $valoracionModel = new Valoracion();
        $errores = 0;

        foreach ($ratings as $idProducto => $datos) {
            $puntuacion = (int) ($datos['puntuacion'] ?? 0);
            $comentario = trim($datos['comentario'] ?? '');

            if ($puntuacion < 1 || $puntuacion > 5) {
                $errores++;
                continue;
            }

            $resultado = $valoracionModel->guardarValoracion($idUsuario, $idProducto, $puntuacion, $comentario);

            if (!$resultado) {
                $errores++;
            }
        }

        if ($errores > 0) {
            $_SESSION['errores'] = "Algunas valoraciones no se pudieron guardar.";
        } else {
            $_SESSION['exito'] = "Todas las valoraciones fueron guardadas correctamente.";
        }

        header('Location: /home');
    }
}
