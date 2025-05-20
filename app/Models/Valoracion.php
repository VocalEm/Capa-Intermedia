<?php

namespace App\Models;

class Valoracion extends BaseModel
{

    public function guardarValoracion($idUsuario, $idProducto, $puntuacion, $comentario)
    {
        $sql = "
        INSERT INTO valoracion (ID_USUARIO, ID_PRODUCTO, PUNTUACION, COMENTARIO) 
        VALUES (:idUsuario, :idProducto, :puntuacion, :comentario)
        ON DUPLICATE KEY UPDATE 
            PUNTUACION = :puntuacion,
            COMENTARIO = :comentario;
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->bindParam(':puntuacion', $puntuacion);
        $stmt->bindParam(':comentario', $comentario);

        return $stmt->execute();
    }


    public function obtenerValoraciones($idProducto)
    {
        $sql = "
        SELECT 
            v.PUNTUACION,
            v.COMENTARIO,
            u.USERNAME 
        FROM valoracion v
        INNER JOIN usuario u ON v.ID_USUARIO = u.ID
        WHERE v.ID_PRODUCTO = :idProducto;
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerPromedioValoracion($idProducto)
    {
        $sql = "
        SELECT 
            COALESCE(AVG(PUNTUACION), 0) AS promedio_valoracion,
            COUNT(ID) AS total_valoraciones
        FROM valoracion 
        WHERE ID_PRODUCTO = :idProducto;
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();

        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si no hay valoraciones, establecer valores predeterminados
        if (!$resultado || $resultado['total_valoraciones'] == 0) {
            return [
                'promedio_valoracion' => 0,
                'total_valoraciones' => 0
            ];
        }

        return $resultado;
    }
}
