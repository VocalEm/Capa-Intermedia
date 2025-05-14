<?php

namespace App\Models;

class Producto extends BaseModel
{

    public function crearProducto($datos)
    {
        $query = "
            INSERT INTO producto 
            (NOMBRE, DESCRIPCION, PRECIO, STOCK, TIPO_PUBLICACION, AUTORIZADO, DISPONIBLE, ID_VENDEDOR)
            VALUES 
            (:nombre, :descripcion, :precio, :stock, :tipo_publicacion, 0, 1, :id_vendedor)
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':precio', $datos['precio']);
        $stmt->bindParam(':stock', $datos['stock']);
        $stmt->bindParam(':tipo_publicacion', $datos['tipo_publicacion']);
        $stmt->bindParam(':id_vendedor', $datos['id_vendedor']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }


    public function asociarCategorias($productoId, $categorias)
    {
        $query = "
            INSERT INTO producto_categoria (ID_PRODUCTO, ID_CATEGORIA) 
            VALUES (:id_producto, :id_categoria)
        ";
        $stmt = $this->db->prepare($query);

        foreach ($categorias as $categoriaId) {
            $stmt->bindParam(':id_producto', $productoId);
            $stmt->bindParam(':id_categoria', $categoriaId);

            if (!$stmt->execute()) {
                return false;
            }
        }

        return true;
    }


    public function guardarMultimedia($productoId, $multimedia)
    {
        $query = "
            INSERT INTO producto_multimedia (RUTA_MULTIMEDIA, ID_PRODUCTO) 
            VALUES (:ruta_multimedia, :id_producto)
        ";
        $stmt = $this->db->prepare($query);

        foreach ($multimedia as $ruta) {
            $stmt->bindParam(':ruta_multimedia', $ruta);
            $stmt->bindParam(':id_producto', $productoId);

            if (!$stmt->execute()) {
                return false;
            }
        }

        return true;
    }
}
