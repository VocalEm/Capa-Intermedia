<?php

namespace App\Models;

class Carrito extends BaseModel
{
    public function agregarProductoCarrito($idUsuario, $idProducto)
    {
        $querySelect = "SELECT CANTIDAD FROM carrito WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($querySelect);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $productoEnCarrito = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($productoEnCarrito) {
            // Si el producto ya existe en el carrito, incrementamos la cantidad
            $queryUpdate = "
            UPDATE carrito 
            SET CANTIDAD = CANTIDAD + 1 
            WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto
        ";

            $stmt = $this->db->prepare($queryUpdate);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idProducto', $idProducto);
            return $stmt->execute();
        } else {
            // Si el producto no existe, lo insertamos con cantidad = 1
            $queryInsert = "
            INSERT INTO carrito (ID_USUARIO, ID_PRODUCTO, CANTIDAD) 
            VALUES (:idUsuario, :idProducto, 1)
        ";

            $stmt = $this->db->prepare($queryInsert);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idProducto', $idProducto);
            return $stmt->execute();
        }
    }

    public function agregarProductoCarritoCotizacion($idUsuario, $idProducto, $precio)
    {
        // Si el producto no existe, lo insertamos con cantidad = 1
        $queryInsert = "
            INSERT INTO carrito (ID_USUARIO, ID_PRODUCTO, CANTIDAD,PRECIO_COTIZACION) 
            VALUES (:idUsuario, :idProducto, 1,:precio)
        ";

        $stmt = $this->db->prepare($queryInsert);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->bindParam(':precio', $precio);
        return $stmt->execute();
    }


    public function eliminarProductoCarrito($idUsuario, $idProducto)
    {
        // Si el producto no existe, lo insertamos con cantidad = 1
        $queryDelete = "DELETE FROM carrito WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($queryDelete);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }


    public function aumentarCantidadProducto($idUsuario, $idProducto)
    {
        // Primero, obtenemos el stock disponible del producto
        $queryStock = "SELECT STOCK FROM producto WHERE ID = :idProducto";
        $stmt = $this->db->prepare($queryStock);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $producto = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$producto) {
            return false; // Producto no existe
        }

        $stockDisponible = $producto['STOCK'];

        // Verificamos la cantidad actual en el carrito
        $queryCarrito = "SELECT CANTIDAD FROM carrito WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($queryCarrito);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $carrito = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$carrito) {
            return false; // Producto no está en el carrito
        }

        $cantidadActual = $carrito['CANTIDAD'];

        // Si la cantidad actual es igual al stock disponible, no se puede aumentar más
        if ($cantidadActual >= $stockDisponible) {
            return "error";
        }

        // Actualizamos la cantidad
        $queryUpdate = "UPDATE carrito SET CANTIDAD = CANTIDAD + 1 WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($queryUpdate);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }

    public function reducirCantidadProducto($idUsuario, $idProducto)
    {
        // Verificamos la cantidad actual en el carrito
        $queryCarrito = "SELECT CANTIDAD FROM carrito WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($queryCarrito);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $carrito = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$carrito) {
            return false; // Producto no está en el carrito
        }

        $cantidadActual = $carrito['CANTIDAD'];

        // Si la cantidad es 1, eliminamos el producto del carrito
        if ($cantidadActual <= 1) {
            $queryDelete = "DELETE FROM carrito WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
            $stmt = $this->db->prepare($queryDelete);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idProducto', $idProducto);
            return $stmt->execute();
        }

        // Si la cantidad es mayor a 1, la reducimos
        $queryUpdate = "UPDATE carrito SET CANTIDAD = CANTIDAD - 1 WHERE ID_USUARIO = :idUsuario AND ID_PRODUCTO = :idProducto";
        $stmt = $this->db->prepare($queryUpdate);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idProducto', $idProducto);
        return $stmt->execute();
    }

    public function vaciarCarrito($idUsuario)
    {
        $query = "DELETE FROM carrito WHERE ID_USUARIO = :idUsuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario);

        return $stmt->execute();
    }
}
