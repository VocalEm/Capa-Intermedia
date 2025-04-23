<?php

namespace App\Models;

use PDO;

class Usuario extends BaseModel
{
    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM USUARIO WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO USUARIO (NOMBRE, APELLIDO_P, APELLIDO_M, SEXO, CORREO, USERNAME, PASSW, ROL, IMAGEN, FECHA_NACIMIENTO, PRIVACIDAD, ES_SUPERADMIN)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['apellido_p'],
            $data['apellido_m'],
            $data['sexo'],
            $data['correo'],
            $data['username'],
            password_hash($data['passw'], PASSWORD_BCRYPT),
            $data['rol'],
            $data['imagen'] ?? null,
            $data['fecha_nacimiento'],
            $data['privacidad'] ?? 1,
            $data['es_superadmin'] ?? 0
        ]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM USUARIO");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
