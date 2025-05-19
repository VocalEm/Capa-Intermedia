<?php

namespace App\Models;

class Pago extends BaseModel
{
    public function crearOrden($idUsuario, $total)
    {
        $query = "
            INSERT INTO orden (ID_USUARIO, TOTAL, FECHA_HORA) 
            VALUES (:idUsuario, :total, NOW())
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':total', $total);

        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Retornar el ID de la orden creada
        }

        return false;
    }

    public function crearDetallesOrden($ordenId, $productos)
    {
        $query = "
            INSERT INTO orden_detalle (ID_ORDEN, ID_PRODUCTO, CANTIDAD, PRECIO_UNITARIO, IMPORTE)
            VALUES (:idOrden, :idProducto, :cantidad, :precioUnitario, :importe)
        ";

        $stmt = $this->db->prepare($query);

        foreach ($productos as $producto) {
            $importe = $producto['PRECIO'] * $producto['CANTIDAD'];

            $stmt->bindParam(':idOrden', $ordenId);
            $stmt->bindParam(':idProducto', $producto['ID']);
            $stmt->bindParam(':cantidad', $producto['CANTIDAD']);
            $stmt->bindParam(':precioUnitario', $producto['PRECIO']);
            $stmt->bindParam(':importe', $importe);

            if (!$stmt->execute()) {
                return false;
            }
        }

        return true;
    }
}
