<?php

namespace App\Models;

use PDO;

class Comentario extends BaseModel
{
    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM COMENTARIO WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        // Implementación aquí
    }

    public function obtenerTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM COMENTARIO");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
