<?php

namespace App\Helpers;

class UsuarioSesion
{
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function obtener()
    {
        self::iniciar();
        return $_SESSION['usuario'] ?? null;
    }

    public static function id()
    {
        $usuario = self::obtener();
        return $usuario['id'] ?? null;
    }

    public static function rol()
    {
        $usuario = self::obtener();
        return $usuario['rol'] ?? null;
    }

    public static function cerrar()
    {
        self::iniciar();
        session_destroy();
    }

    public static function estaAutenticado()
    {
        return self::obtener() !== null;
    }
}
