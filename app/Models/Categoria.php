<?php

namespace App\Models;

use PDO;

class Categoria extends BaseModel
{
    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM CATEGORIA WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        // Implementación aquí
    }

    public function obtenerTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM CATEGORIA");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
