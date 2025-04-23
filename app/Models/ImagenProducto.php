<?php

namespace App\Models;

use PDO;

class ImagenProducto extends BaseModel
{
    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM IMAGENPRODUCTO WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        // Implementación aquí
    }

    public function obtenerTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM IMAGENPRODUCTO");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
