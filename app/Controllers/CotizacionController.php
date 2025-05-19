<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Chat;

class CotizacionController
{
    /**
     * Crear un chat
     */
    public function crearChat($idVendedor)
    {
        $id_Usuario = UsuarioSesion::id();
        $idProducto = $_POST['idProducto'];

        $chatModel = new Chat();
        $chatId = $chatModel->crearChat($idVendedor, $id_Usuario, $idProducto);

        if ($chatId) {
            header("Location: /chat/$chatId");
            exit();
        }

        header("Location: /chat");
        exit();
    }

    /**
     * Mostrar todos los chats del usuario
     */
    public function mostrarChats()
    {
        $chatModel = new Chat();
        $id_Usuario = UsuarioSesion::id();
        $chats = $chatModel->obtenerChats($id_Usuario);

        require_once __DIR__ . '/../Views/allchats.php';
    }

    /**
     * Mostrar un chat específico
     */
    public function mostrarChat($idChat)
    {
        $chatModel = new Chat();
        $id_Usuario = UsuarioSesion::id();

        $chats = $chatModel->obtenerChat($idChat, $id_Usuario);

        if (!$chats) {
            header("Location: /chat");
            exit();
        }

        $chat = $chats[0];
        $oferta = $chatModel->obtenerOfertaPendiente($idChat);
        $usuarioExterno = ($id_Usuario == $chat['comprador_id']) ? $chat['VENDEDOR'] : $chat['COMPRADOR'];
        // \var_dump($chats);

        require_once __DIR__ . '/../Views/chat.php';
    }

    /**
     * Obtener mensajes y oferta activa (JSON para AJAX)
     */
    public function obtenerMensajesOferta($idChat)
    {
        $chatModel = new Chat();
        $mensajes = $chatModel->obtenerMensajes($idChat);
        $oferta = $chatModel->obtenerOfertaPendiente($idChat);

        echo json_encode([
            'status' => 'success',
            'mensajes' => $mensajes,
            'oferta' => $oferta
        ]);
        exit();
    }



    public function enviarMensaje()
    {
        $chatModel = new Chat();
        $id_Usuario = UsuarioSesion::id();
        $mensaje = $_POST['mensaje'];
        $idChat = $_POST['idChat'];

        if ($chatModel->enviarMensaje($idChat, $id_Usuario, $mensaje)) {
            header("Location: /chat/$idChat");
        } else {
            header("Location: /perfil");
        }
        exit();
    }

    public function crearOferta()
    {
        $chatModel = new Chat();
        $id_Usuario = UsuarioSesion::id();
        $precio = $_POST['precio'];
        $idChat = $_POST['idChat'];

        if ($chatModel->crearOferta($idChat, $precio)) {
            header("Location: /chat/$idChat");
        } else {
            header("Location: /perfil");
        }
        exit();
    }

    public function rechazarOferta($idChat)
    {

        $chatModel = new Chat();
        $id_Usuario = UsuarioSesion::id();

        if ($chatModel->rechazarOferta($idChat)) {
            header("Location: /chat/$idChat");
        } else {
            header("Location: /perfil");
        }
        exit();
    }

    public function aceptarOferta()
    {
        $id_Usuario = UsuarioSesion::id();
        $idChat = $_POST['idChat'];
        $precio = $_POST['precio'];
        $idProducto = $_POST['idProducto'];
        $carritoModel = new \App\Models\Carrito();
        $tarea = $carritoModel->agregarProductoCarritoCotizacion($id_Usuario, $idProducto, $precio);
        if ($tarea) {
            $chatModel = new Chat();
            $chatModel->modificarEstadoChat($idChat, 'cerrado');
            $_SESSION['exito'] = "Oferta aceptada y producto agregado al carrito.";
            header("Location: /carrito");
        } else {
            $_SESSION['errores'] = "error";
            header("Location: /perfil");
        }
    }
}
