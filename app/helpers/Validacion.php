<?php

namespace App\Helpers;

class Validacion
{
    public static function email($correo)
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) ? null : "El correo electrónico no tiene un formato válido.";
    }

    public static function textoMin($texto, $campo, $min = 3)
    {
        return strlen($texto) < $min ? "El {$campo} debe tener al menos {$min} caracteres." : null;
    }

    public static function password($clave)
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $clave)
            ? null : "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
    }

    public static function edadValida($fechaNacimiento)
    {
        $edad = (new \DateTime())->diff(new \DateTime($fechaNacimiento))->y;
        return ($edad < 18 || $edad > 100) ? "La edad debe estar entre 18 y 100 años." : null;
    }

    public static function imagenValida($archivo)
    {
        if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
            return in_array($ext, ['jpg', 'jpeg', 'png']) ? null : "La imagen debe ser JPG, JPEG o PNG.";
        }
        return "Debe subir una imagen de avatar.";
    }

    public static function validarSessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
