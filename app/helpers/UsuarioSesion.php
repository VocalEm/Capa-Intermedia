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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Eliminar datos de sesión
        $_SESSION = [];
        session_unset();
        session_destroy();

        // Eliminar la cookie `TOKEN`
        if (isset($_COOKIE['TOKEN'])) {
            setcookie('TOKEN', '', time() - 3600, "/");
        }
    }



    public static function estaAutenticado()
    {
        return self::obtener() !== null;
    }
}
