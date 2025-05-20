<?php

namespace App\Models;

class Usuario extends BaseModel
{

    public function encontrarPorCorreoONickname($identificador)
    {
        $identificador = strtolower(trim($identificador)); // Convertir a minúsculas
        $query = "SELECT * FROM USUARIO WHERE IS_ELIMINADO = 0 AND (LOWER(CORREO) = :identificador OR USERNAME = :identificador) LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':identificador', $identificador);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function registrar($datos)
    {
        // Asegurar que privacidad tenga un valor válido
        $datos['privacidad'] = isset($datos['privacidad']) ? (int)$datos['privacidad'] : 0;

        $query = "INSERT INTO USUARIO (
            NOMBRE, APELLIDO_P, APELLIDO_M, SEXO, CORREO, USERNAME, PASSW,
            ROL, IMAGEN, FECHA_NACIMIENTO, PRIVACIDAD, ES_SUPERADMIN
        ) VALUES (
            :nombre, :apellido_p, :apellido_m, :sexo, :correo, :username, :passw,
            :rol, :imagen, :fecha_nacimiento, :privacidad, 0
        )";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellido_p', $datos['apellido_p']);
        $stmt->bindParam(':apellido_m', $datos['apellido_m']);
        $stmt->bindParam(':sexo', $datos['sexo']);
        $stmt->bindParam(':correo', $datos['correo']);
        $stmt->bindParam(':username', $datos['username']);
        $stmt->bindParam(':passw', $datos['passw']);
        $stmt->bindParam(':rol', $datos['rol']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $stmt->bindParam(':privacidad', $datos['privacidad'], \PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public function obtenerPorId($id)
    {
        $query = "SELECT * FROM USUARIO WHERE ID = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function actualizarToken($userId, $token)
    {
        $query = "UPDATE USUARIO SET TOKEN = :token WHERE ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function obtenerPorToken($token)
    {
        $query = "SELECT * FROM USUARIO WHERE TOKEN = :token LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obtenerAdministradores()
    {
        $query = "SELECT ID, CORREO, USERNAME FROM USUARIO WHERE ROL = 'administrador'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function eliminarAdministrador($id)
    {
        $query = "DELETE FROM USUARIO WHERE ID = :id AND ROL = 'administrador'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarUsuarios($busqueda)
    {
        $query = "
        SELECT * FROM USUARIO 
        WHERE 
            IS_ELIMINADO = 0 AND
            (ROL NOT IN ('superadmin', 'administrador')) AND (
            USERNAME LIKE :busqueda 
            OR CONCAT(NOMBRE, ' ', APELLIDO_P, ' ', APELLIDO_M) LIKE :busqueda )";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function desctivarUsuario($id)
    {
        $query = "UPDATE USUARIO SET IS_ELIMINADO = 1 WHERE ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function editarPerfil() {}

    public function actualizarPerfil($usuarioId, $datos)
    {
        $campos = [];
        $valores = [];

        // Solo permitir campos válidos
        $permitidos = ['NOMBRE', 'APELLIDO_P', 'APELLIDO_M', 'CORREO', 'USERNAME', 'PRIVACIDAD', 'SEXO', 'IMAGEN', 'PASSW'];

        foreach ($permitidos as $campo) {
            if (isset($datos[$campo])) {
                $campos[] = "$campo = ?";
                $valores[] = $datos[$campo];
            }
        }

        if (empty($campos)) return false;

        $valores[] = $usuarioId;

        $sql = "UPDATE usuario SET " . implode(', ', $campos) . " WHERE ID = ? AND IS_ELIMINADO = 0";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($valores);
    }
}
