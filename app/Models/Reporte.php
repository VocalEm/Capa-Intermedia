<?php

namespace App\Models;

use PDO;

class Reporte extends BaseModel
{
    // Total ganado por el vendedor
    public function obtenerTotalGanado($idVendedor)
    {
        $sql = "SELECT SUM(od.IMPORTE) as total_ganado
                FROM orden_detalle od
                JOIN producto p ON od.ID_PRODUCTO = p.ID
                WHERE p.ID_VENDEDOR = :idVendedor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idVendedor' => $idVendedor]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_ganado'] ?? 0;
    }

    // Lista de órdenes con detalle de productos vendidos por el vendedor
    public function obtenerOrdenesConDetalles($idVendedor)
    {
        $sql = "SELECT o.ID as orden_id, o.FECHA_HORA, o.TOTAL, 
                       od.ID as detalle_id, od.CANTIDAD, od.PRECIO_UNITARIO, od.IMPORTE,
                       p.NOMBRE as producto_nombre, p.ID as producto_id
                FROM orden o
                JOIN orden_detalle od ON o.ID = od.ID_ORDEN
                JOIN producto p ON od.ID_PRODUCTO = p.ID
                WHERE p.ID_VENDEDOR = :idVendedor
                ORDER BY o.FECHA_HORA DESC, o.ID ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idVendedor' => $idVendedor]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar por orden para evitar filas repetidas
        $ordenes = [];
        foreach ($resultados as $row) {
            $oid = $row['orden_id'];
            if (!isset($ordenes[$oid])) {
                $ordenes[$oid] = [
                    'orden_id' => $row['orden_id'],
                    'fecha_hora' => $row['FECHA_HORA'],
                    'total' => $row['TOTAL'],
                    'detalles' => []
                ];
            }
            $ordenes[$oid]['detalles'][] = [
                'detalle_id' => $row['detalle_id'],
                'producto_id' => $row['producto_id'],
                'producto_nombre' => $row['producto_nombre'],
                'cantidad' => $row['CANTIDAD'],
                'precio_unitario' => $row['PRECIO_UNITARIO'],
                'importe' => $row['IMPORTE']
            ];
        }
        return array_values($ordenes);
    }

    // Reporte de ventas por producto (total vendido por producto)
    public function obtenerVentasPorProducto($idVendedor)
    {
        $sql = "SELECT p.ID as producto_id, p.NOMBRE as producto_nombre,
                       SUM(od.CANTIDAD) as total_cantidad,
                       SUM(od.IMPORTE) as total_vendido
                FROM producto p
                LEFT JOIN orden_detalle od ON od.ID_PRODUCTO = p.ID
                WHERE p.ID_VENDEDOR = :idVendedor
                GROUP BY p.ID, p.NOMBRE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idVendedor' => $idVendedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compras realizadas por un usuario comprador (con desglose)
    public function obtenerComprasPorUsuario($idUsuario)
    {
        $sql = "SELECT o.ID as orden_id, o.FECHA_HORA, o.TOTAL,
                       od.ID as detalle_id, od.CANTIDAD, od.PRECIO_UNITARIO, od.IMPORTE,
                       p.NOMBRE as producto_nombre, p.ID as producto_id
                FROM orden o
                JOIN orden_detalle od ON o.ID = od.ID_ORDEN
                JOIN producto p ON od.ID_PRODUCTO = p.ID
                WHERE o.ID_USUARIO = :idUsuario
                ORDER BY o.FECHA_HORA DESC, o.ID ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar por orden para evitar filas repetidas
        $ordenes = [];
        foreach ($resultados as $row) {
            $oid = $row['orden_id'];
            if (!isset($ordenes[$oid])) {
                $ordenes[$oid] = [
                    'orden_id' => $row['orden_id'],
                    'fecha_hora' => $row['FECHA_HORA'],
                    'total' => $row['TOTAL'],
                    'detalles' => []
                ];
            }
            $ordenes[$oid]['detalles'][] = [
                'detalle_id' => $row['detalle_id'],
                'producto_id' => $row['producto_id'],
                'producto_nombre' => $row['producto_nombre'],
                'cantidad' => $row['CANTIDAD'],
                'precio_unitario' => $row['PRECIO_UNITARIO'],
                'importe' => $row['IMPORTE']
            ];
        }
        return array_values($ordenes);
    }
}
