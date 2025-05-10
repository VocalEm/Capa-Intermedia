<?php

namespace App\Models;

class Lista extends BaseModel
{

    // Crear una lista
    public function crearLista($datos)
    {
        $sql = "INSERT INTO listas (NOMBRE, DESCRIPCION, IMAGEN, PRIVACIDAD, ID_USUARIO) 
                VALUES (:nombre, :descripcion, :imagen, :privacidad, :idUsuario)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        $stmt->bindParam(':privacidad', $datos['privacidad'], \PDO::PARAM_BOOL);
        $stmt->bindParam(':idUsuario', $datos['idUsuario']);
        return $stmt->execute();
    }

    // Obtener listas de un usuario
    public function obtenerListasPorUsuario($datos)
    {
        $sql = "SELECT * FROM listas WHERE ID_USUARIO = :idUsuario ORDER BY ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $datos['idUsuario']);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener productos de una lista
    public function obtenerProductosDeLista($datos)
    {
        $sql = "SELECT p.ID, p.NOMBRE, p.PRECIO, ip.RUTA_IMAGEN 
                FROM listas_productos lp
                JOIN producto p ON lp.ID_PRODUCTO = p.ID
                LEFT JOIN imagenes_producto ip ON ip.ID_PRODUCTO = p.ID
                WHERE lp.ID_LISTA = :idLista";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $datos['idLista']);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerListasConProductos($idUsuario)
    {
        $sql = "
        SELECT 
            l.ID AS lista_id,
            l.NOMBRE AS lista_nombre,
            l.DESCRIPCION AS lista_descripcion,
            l.PRIVACIDAD AS lista_privacidad,
            l.IMAGEN AS lista_imagen,
            lp.ID_PRODUCTO,
            p.NOMBRE AS producto_nombre,
            p.PRECIO AS producto_precio,
            ip.RUTA_IMAGEN AS producto_imagen
        FROM listas l
        LEFT JOIN listas_productos lp ON l.ID = lp.ID_LISTA
        LEFT JOIN producto p ON lp.ID_PRODUCTO = p.ID
        LEFT JOIN imagenes_producto ip ON p.ID = ip.ID_PRODUCTO
        WHERE l.ID_USUARIO = :idUsuario
        ORDER BY l.ID DESC, lp.ID_PRODUCTO ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    // Eliminar una lista y sus productos
    public function eliminarLista($datos)
    {
        $this->db->beginTransaction();

        try {
            // Eliminar los productos de la lista
            $sql = "DELETE FROM listas_productos WHERE ID_LISTA = :idLista";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idLista', $datos['idLista']);
            $stmt->execute();

            // Eliminar la lista
            $sql = "DELETE FROM listas WHERE ID = :idLista";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idLista', $datos['idLista']);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }


    // Agregar un producto a una lista
    public function agregarProductoALista($datos)
    {
        $sql = "INSERT INTO listas_productos (ID_LISTA, ID_PRODUCTO) VALUES (:idLista, :idProducto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $datos['idLista']);
        $stmt->bindParam(':idProducto', $datos['idProducto']);
        return $stmt->execute();
    }

    // Eliminar un producto de una lista
    public function eliminarProductoDeLista($datos)
    {
        $sql = "DELETE FROM listas_productos WHERE ID_LISTA = :idLista AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $datos['idLista']);
        $stmt->bindParam(':idProducto', $datos['idProducto']);
        return $stmt->execute();
    }
}
