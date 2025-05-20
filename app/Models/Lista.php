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
    public function obtenerListasPorUsuario($idUsuario)
    {
        $sql = "SELECT * FROM listas WHERE ID_USUARIO = :idUsuario ORDER BY ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener listas de un usuario
    public function obtenerListasPorId($idLista)
    {
        $sql = "SELECT a.*, b.USERNAME AS USUARIO, b.ID AS ID_USUARIO FROM listas a JOIN usuario b ON a.ID_USUARIO = b.ID WHERE a.ID = :idLista ORDER BY ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $idLista);
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
    public function agregarProductoALista($idLista, $idProducto)
    {
        // Verificar si el producto ya existe en la lista
        $checkSql = "SELECT COUNT(*) FROM listas_productos WHERE ID_LISTA = :idLista AND ID_PRODUCTO = :idProducto";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':idLista', $idLista);
        $checkStmt->bindParam(':idProducto', $idProducto);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();

        if ($exists > 0) {
            // Ya existe el producto en la lista
            return false;
        }

        // Si no existe, procedemos a insertar
        $sql = "INSERT INTO listas_productos (ID_LISTA, ID_PRODUCTO) VALUES (:idLista, :idProducto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $idLista);
        $stmt->bindParam(':idProducto', $idProducto);

        return $stmt->execute();
    }


    // Eliminar un producto de una lista
    public function eliminarProductoDeLista($idLista, $idProducto)
    {
        $sql = "DELETE FROM listas_productos WHERE ID_LISTA = :idLista AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $idLista);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }
}
