<?php

namespace App\Models;

class Reportes extends BaseModel
{
    public function consultaVentas() {}

    public function consultaDetallada()
    {
        $sql = "SELECT 
        o.FECHA_HORA AS fecha_venta,
        p.NOMBRE AS nombre_producto,
        p.DESCRIPCION AS descripcion,
        od.PRECIO_UNITARIO AS precio,
        p.STOCK AS stock,
        c.TITULO AS categoria,
        COALESCE(v.PUNTUACION, 0) AS calificacion
        FROM orden o
        INNER JOIN orden_detalle od ON o.ID = od.ID_ORDEN
        INNER JOIN producto p ON od.ID_PRODUCTO = p.ID
        INNER JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        INNER JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        LEFT JOIN valoracio n v ON v.ID_PRODUCTO = p.ID
        WHERE p.ID_VENDEDOR = :idVendedor
        ORDER BY o.FECHA_HORA DESC;";
    }

    public function consultaAgrupada() {}
}
