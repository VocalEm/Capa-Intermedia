<?php

namespace App\Models;

class Categoria extends BaseModel
{

    public function agregarCategoria($datos)
    {
        $query = "
            INSERT INTO categoria (TITULO, DESCRIPCION, ID_CREADOR) 
            VALUES (:titulo, :descripcion, :id_creador)
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':id_creador', $datos['id_creador']);

        return $stmt->execute();
    }

    public function obtenerCategorias()
    {
        $query = "SELECT * FROM CATEGORIA";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
