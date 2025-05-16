<?php

namespace App\Models;

use App\Helpers\UsuarioSesion;

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

    public function mostrarProductosVendedor($id_vendedor)
    {
        $sqlProductos = "SELECT * FROM PRODUCTO WHERE ID_VENDEDOR = :idVendedor AND AUTORIZADO = 1 AND DISPONIBLE = 1;";
        $sqlMultimedia = "SELECT RUTA_MULTIMEDIA FROM PRODUCTO_MULTIMEDIA WHERE ID_PRODUCTO = :idProducto;";
        $sqlCategorias = "SELECT B.TITULO FROM PRODUCTO_CATEGORIA A 
                      JOIN CATEGORIA B ON A.ID_CATEGORIA = B.ID 
                      WHERE A.ID_PRODUCTO = :idProducto";

        $productos = [];

        // Obtener los productos del vendedor
        $stmt = $this->db->prepare($sqlProductos);
        $stmt->bindParam(':idVendedor', $id_vendedor);
        $stmt->execute();
        $dataProductos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Iterar sobre cada producto
        foreach ($dataProductos as $producto) {
            $idProducto = $producto['ID'];

            // Obtener las rutas multimedia del producto
            $stmtMultimedia = $this->db->prepare($sqlMultimedia);
            $stmtMultimedia->bindParam(':idProducto', $idProducto);
            $stmtMultimedia->execute();
            $multimedia = $stmtMultimedia->fetchAll(\PDO::FETCH_COLUMN);

            // Obtener las categorías del producto
            $stmtCategorias = $this->db->prepare($sqlCategorias);
            $stmtCategorias->bindParam(':idProducto', $idProducto);
            $stmtCategorias->execute();
            $categorias = $stmtCategorias->fetchAll(\PDO::FETCH_COLUMN);

            // Agregar el producto con multimedia y categorías al arreglo
            $productos[] = [
                'producto' => $producto,
                'multimedia' => $multimedia,
                'categorias' => $categorias
            ];
        }

        return $productos;
    }

    public function mostrarProductosPendientes($lastUpdate = 0)
    {
        $sql = "
        SELECT 
            p.*, 
            u.USERNAME AS vendedor_username,
            u.CORREO AS vendedor_correo,
            GROUP_CONCAT(DISTINCT pm.RUTA_MULTIMEDIA) AS multimedia,
            GROUP_CONCAT(DISTINCT c.TITULO) AS categorias
        FROM producto p
        LEFT JOIN usuario u ON p.ID_VENDEDOR = u.ID
        LEFT JOIN producto_multimedia pm ON p.ID = pm.ID_PRODUCTO
        LEFT JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        LEFT JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        WHERE p.AUTORIZADO = 0 AND p.DISPONIBLE = 1
        GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':lastUpdate', $lastUpdate, \PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }
    public function aprobarProducto($id_producto)
    {
        $query = "UPDATE producto SET AUTORIZADO = 1 WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $id_producto, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function rechazarProducto($id_producto)
    {
        $query = "UPDATE producto SET AUTORIZADO = -1 WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $id_producto, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
