<?php

namespace App\Models;

use App\Helpers\UsuarioSesion;

class Producto extends BaseModel
{

    //creacion de producto
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

    //productos en perfil

    public function mostrarProductosVendedor($id_vendedor)
    {
        $sql = "SELECT 
        p.*, 
        u.USERNAME AS vendedor_username,
        u.CORREO AS vendedor_correo,
        GROUP_CONCAT(DISTINCT pm.RUTA_MULTIMEDIA ORDER BY pm.RUTA_MULTIMEDIA ASC) AS multimedia,
        GROUP_CONCAT(DISTINCT c.TITULO ORDER BY c.TITULO ASC) AS categorias
        FROM producto p
        LEFT JOIN usuario u ON p.ID_VENDEDOR = u.ID
        LEFT JOIN producto_multimedia pm ON p.ID = pm.ID_PRODUCTO
        LEFT JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        LEFT JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        WHERE p.AUTORIZADO = 1 
        AND p.DISPONIBLE = 1 
        AND p.ID_VENDEDOR = :idVendedor
        GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);

        // Ahora se hace el bindParam antes del execute
        $stmt->bindParam(':idVendedor', $id_vendedor, \PDO::PARAM_INT);
        $stmt->execute();

        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Convertimos multimedia y categorias a arrays
        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    //producto individual


    public function mostrarProductoPorId($id_producto)
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
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1 AND p.ID = :idProducto
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idProducto', $id_producto);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    //busquedas y catalogo

    public function mostrarProductos()
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
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function mostrarProductosDescripcion($descripcion)
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
        WHERE p.AUTORIZADO = 1 
          AND p.DISPONIBLE = 1";

        // Dividir la descripción en palabras utilizando espacios
        $palabras = array_filter(explode(' ', $descripcion), fn($word) => !empty($word));

        $params = [];

        if (!empty($palabras)) {
            $likeClauses = [];

            foreach ($palabras as $palabra) {
                $likeClauses[] = "p.DESCRIPCION LIKE ?";
                $params[] = '%' . $palabra . '%';
            }

            // Aquí usamos OR para que coincida con cualquiera de las palabras
            $sql .= " AND (" . implode(' AND ', $likeClauses) . ")";
        }

        $sql .= " GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function mostrarProductosNombre($descripcion)
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
        WHERE p.AUTORIZADO = 1 
          AND p.DISPONIBLE = 1";

        // Dividir la descripción en palabras utilizando espacios
        $palabras = array_filter(explode(' ', $descripcion), fn($word) => !empty($word));

        $params = [];

        if (!empty($palabras)) {
            $likeClauses = [];

            foreach ($palabras as $palabra) {
                $likeClauses[] = "p.NOMBRE LIKE ?";
                $params[] = '%' . $palabra . '%';
            }

            // Aquí usamos OR para que coincida con cualquiera de las palabras
            $sql .= " AND (" . implode(' AND ', $likeClauses) . ")";
        }

        $sql .= " GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function mostrarProductosCategorias($categorias)
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
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1";

        if (!empty($categorias)) {
            $placeholders = implode(',', array_fill(0, count($categorias), '?'));

            $sql .= "
        AND p.ID IN (
            SELECT pc.ID_PRODUCTO
            FROM producto_categoria pc
            WHERE pc.ID_CATEGORIA IN ($placeholders)
            GROUP BY pc.ID_PRODUCTO
            HAVING COUNT(DISTINCT pc.ID_CATEGORIA) = " . count($categorias) . "
        )";
        }

        $sql .= " GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($categorias);
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function mostrarProductosDescripcionCategoria($descripcion, $categorias)
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
        WHERE p.AUTORIZADO = 1 
          AND p.DISPONIBLE = 1";

        $params = [];
        $likeClauses = [];

        /**
         * 1. Búsqueda por Descripción
         */
        $palabras = array_filter(explode(' ', $descripcion), fn($word) => !empty($word));

        if (!empty($palabras)) {
            foreach ($palabras as $palabra) {
                $likeClauses[] = "(p.DESCRIPCION LIKE ? OR p.NOMBRE LIKE ?)";
                $params[] = '%' . $palabra . '%';
                $params[] = '%' . $palabra . '%';
            }

            // Usamos AND para que cada palabra debe estar presente
            $sql .= " AND (" . implode(' AND ', $likeClauses) . ")";
        }

        /**
         * 2. Búsqueda por Categorías
         */
        if (!empty($categorias)) {
            $placeholders = implode(',', array_fill(0, count($categorias), '?'));

            $sql .= " AND p.ID IN (
            SELECT pc.ID_PRODUCTO
            FROM producto_categoria pc
            WHERE pc.ID_CATEGORIA IN ($placeholders)
            GROUP BY pc.ID_PRODUCTO
            HAVING COUNT(DISTINCT pc.ID_CATEGORIA) = " . count($categorias) . "
        )";

            $params = array_merge($params, $categorias);
        }

        $sql .= " GROUP BY p.ID";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    //panel administracion

    public function mostrarProductosPendientes()
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
        $query = "UPDATE producto SET AUTORIZADO = 1, ID_ADMIN_AUTORIZADOR = :idAdmin WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $id_producto, \PDO::PARAM_INT);
        $stmt->bindParam(':idAdmin', $_SESSION['usuario']['id'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function rechazarProducto($id_producto)
    {
        $query = "UPDATE producto SET AUTORIZADO = -1,  ID_ADMIN_AUTORIZADOR = :idAdmin WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $id_producto, \PDO::PARAM_INT);
        $stmt->bindParam(':idAdmin', $_SESSION['usuario']['id'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function mostrarProductosPorLista($idLista)
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
        LEFT JOIN listas_productos lp ON lp.ID_PRODUCTO = p.ID 
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1 AND lp.ID_LISTA = :idLista
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idLista', $idLista);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function mostrarProductosPorCarrito($idUsuario)
    {
        $sql = "
        SELECT 
            p.*, 
            u.USERNAME AS vendedor_username,
            u.CORREO AS vendedor_correo,
             MAX(ca.CANTIDAD) AS CANTIDAD,
            GROUP_CONCAT(DISTINCT pm.RUTA_MULTIMEDIA) AS multimedia,
            GROUP_CONCAT(DISTINCT c.TITULO) AS categorias
        FROM producto p
        LEFT JOIN usuario u ON p.ID_VENDEDOR = u.ID
        LEFT JOIN producto_multimedia pm ON p.ID = pm.ID_PRODUCTO
        LEFT JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        LEFT JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        INNER JOIN carrito ca ON ca.ID_PRODUCTO = p.ID
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1 AND ca.ID_USUARIO = :idUsuario 
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function obtenerProductosAutorizadosPorAdmin($idAdmin)
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
        WHERE p.AUTORIZADO = 1 AND p.DISPONIBLE = 1 AND p.ID_ADMIN_AUTORIZADOR = :idAdmin
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idAdmin', $idAdmin);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }

    public function obtenerProductosRechazadosPorAdmin($idAdmin)
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
        WHERE p.AUTORIZADO = -1 AND p.DISPONIBLE = 1 AND p.ID_ADMIN_AUTORIZADOR = :idAdmin
        GROUP BY p.ID
        ORDER BY FECHA_CREACION DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idAdmin', $idAdmin);
        $stmt->execute();
        $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($productos as &$producto) {
            $producto['multimedia'] = !empty($producto['multimedia']) ? explode(',', $producto['multimedia']) : [];
            $producto['categorias'] = !empty($producto['categorias']) ? explode(',', $producto['categorias']) : [];
        }

        return $productos;
    }


    public function actualizarProducto($idProducto, $precio, $stock)
    {
        $query = "UPDATE producto SET PRECIO = :precio, STOCK = :stock WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }

    public function eliminarProducto($idProducto)
    {
        $query = "DELETE FROM producto_multimedia WHERE ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();

        $query = "DELETE FROM producto_categoria WHERE ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();

        $query = "DELETE FROM producto WHERE ID = :idProducto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }
}
