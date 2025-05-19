<?php

namespace App\Models;

class Chat extends BaseModel
{
    public function crearChat($idVendedor, $idComprador, $idProducto)
    {
        $query = "
            INSERT INTO chat (ID_COMPRADOR, ID_VENDEDOR, ESTADO, ID_PRODUCTO) 
            VALUES (:idComprador, :idVendedor, 'abierto', :idProducto)
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idComprador', $idComprador);
        $stmt->bindParam(':idVendedor', $idVendedor);
        $stmt->bindParam(':idProducto', $idProducto);
        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Retornar el ID del chat creado
        }
        return false;
    }

    public function obtenerChats($idUsuario)
    {
        $query = "
        SELECT 
            ch.ID AS chat_id,
            ch.FECHA_CREACION AS fecha_chat,
            ch.ESTADO AS estado_chat,
            ch.ID_PRODUCTO AS producto_id,
            p.NOMBRE AS producto_nombre,
            p.DESCRIPCION AS producto_descripcion,
            p.PRECIO AS producto_precio,
            p.TIPO_PUBLICACION AS tipo_publicacion,
            p.ID_VENDEDOR AS vendedor_id,
            u_vendedor.USERNAME AS vendedor_username,
            u_vendedor.CORREO AS vendedor_correo,
            ch.ID_COMPRADOR AS comprador_id,
            u_comprador.USERNAME AS comprador_username,
            u_comprador.CORREO AS comprador_correo,
            GROUP_CONCAT(DISTINCT pm.RUTA_MULTIMEDIA SEPARATOR '||') AS multimedia,
            GROUP_CONCAT(DISTINCT c.TITULO SEPARATOR '||') AS categorias
        FROM chat ch
        LEFT JOIN usuario u_vendedor ON ch.ID_VENDEDOR = u_vendedor.ID
        LEFT JOIN usuario u_comprador ON ch.ID_COMPRADOR = u_comprador.ID
        LEFT JOIN producto p ON ch.ID_PRODUCTO = p.ID
        LEFT JOIN producto_multimedia pm ON p.ID = pm.ID_PRODUCTO
        LEFT JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        LEFT JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        WHERE ch.ID_COMPRADOR = :idUsuario OR ch.ID_VENDEDOR = :idUsuario
        GROUP BY ch.ID
        ORDER BY ch.FECHA_CREACION DESC;";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        $chats = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($chats as &$chat) {
            // Convertir multimedia y categorias a arreglos
            $chat['multimedia'] = !empty($chat['multimedia']) ? explode('||', $chat['multimedia']) : [];
            $chat['categorias'] = !empty($chat['categorias']) ? explode('||', $chat['categorias']) : [];
        }

        return $chats;
    }

    public function obtenerChat($idChat, $idUsuario)
    {
        $query = "
        SELECT 
            ch.ID,
            ch.FECHA_CREACION ,
            ch.ESTADO ,
            ch.ID_PRODUCTO ,
            p.NOMBRE AS producto_nombre,
            p.DESCRIPCION AS producto_descripcion,
            p.PRECIO AS producto_precio,
            p.TIPO_PUBLICACION AS tipo_publicacion,
            p.ID_VENDEDOR AS vendedor_id,
            u_vendedor.USERNAME AS VENDEDOR,
            u_vendedor.CORREO AS VENDEDOR_CORREO,
            ch.ID_COMPRADOR AS comprador_id,
            u_comprador.USERNAME AS COMPRADOR,
            u_comprador.CORREO AS COMPRADOR_CORREO,
            GROUP_CONCAT(DISTINCT pm.RUTA_MULTIMEDIA SEPARATOR '||') AS multimedia,
            GROUP_CONCAT(DISTINCT c.TITULO SEPARATOR '||') AS categorias
        FROM chat ch
        LEFT JOIN usuario u_vendedor ON ch.ID_VENDEDOR = u_vendedor.ID
        LEFT JOIN usuario u_comprador ON ch.ID_COMPRADOR = u_comprador.ID
        LEFT JOIN producto p ON ch.ID_PRODUCTO = p.ID
        LEFT JOIN producto_multimedia pm ON p.ID = pm.ID_PRODUCTO
        LEFT JOIN producto_categoria pc ON p.ID = pc.ID_PRODUCTO
        LEFT JOIN categoria c ON pc.ID_CATEGORIA = c.ID
        WHERE (ch.ID_COMPRADOR = :idUsuario OR ch.ID_VENDEDOR = :idUsuario) AND ch.ID = :idChat
        GROUP BY ch.ID
        ORDER BY ch.FECHA_CREACION DESC;";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->execute();
        $chats = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($chats as &$chat) {
            // Convertir multimedia y categorias a arreglos
            $chat['multimedia'] = !empty($chat['multimedia']) ? explode('||', $chat['multimedia']) : [];
            $chat['categorias'] = !empty($chat['categorias']) ? explode('||', $chat['categorias']) : [];
        }

        return $chats;
    }

    public function obtenerMensajes($idChat)
    {
        $query = "
            SELECT 
                cm.ID, 
                cm.MENSAJE, 
                cm.FECHA_CREACION, 
                u.USERNAME 
            FROM chat_mensaje cm
            INNER JOIN usuario u ON cm.ID_USUARIO = u.ID
            WHERE cm.ID_CHAT = :idChat
            ORDER BY cm.FECHA_CREACION ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function enviarMensaje($idChat, $idUsuario, $mensaje)
    {
        $query = "
            INSERT INTO chat_mensaje (ID_CHAT, ID_USUARIO, MENSAJE, FECHA_CREACION)
            VALUES (:idChat, :idUsuario, :mensaje, NOW())
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->bindParam(':mensaje', $mensaje, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function obtenerOfertaPendiente($idChat)
    {
        $query = "
            SELECT * 
            FROM oferta 
            WHERE ID_CHAT = :idChat 
            AND ESTADO = 'pendiente'
            LIMIT 1;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function crearOferta($idChat, $precio)
    {
        $ofertaPendiente = $this->obtenerOfertaPendiente($idChat);
        if ($ofertaPendiente) {
            return false; // Ya existe una oferta pendiente
        }

        $query = "
            INSERT INTO oferta (ID_CHAT, PRECIO_ACORDADO, ESTADO)
            VALUES (:idChat, :precio, 'pendiente');
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->bindParam(':precio', $precio, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function rechazarOferta($idChat)
    {
        $query = "
            UPDATE oferta 
            SET ESTADO = 'rechazada' 
            WHERE ID_CHAT = :idChat 
            AND ESTADO = 'pendiente';
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function modificarEstadoChat($idChat, $estado)
    {
        $query = "
            UPDATE chat 
            SET ESTADO = :estado 
            WHERE ID = :idChat;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idChat', $idChat, \PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, \PDO::PARAM_STR);

        return $stmt->execute();
    }
}
