<?php

namespace App\Helpers;

use App\Helpers\Validacion;

class ValidadorRegistro
{
    public static function validar($datos, $archivoAvatar)
    {
        $errores = [];

        if ($err = Validacion::email($datos['correo'])) {
            $errores['correo'] = $err;
        }

        if ($err = Validacion::textoMin($datos['nombre'], 'nombre')) {
            $errores['nombre'] = $err;
        }

        if ($err = Validacion::textoMin($datos['apellido_p'], 'apellido paterno')) {
            $errores['apellido_p'] = $err;
        }

        if ($err = Validacion::textoMin($datos['apellido_m'], 'apellido materno')) {
            $errores['apellido_m'] = $err;
        }

        if ($err = Validacion::textoMin($datos['username'], 'nombre de usuario')) {
            $errores['username'] = $err;
        }

        if ($err = Validacion::password($datos['password'])) {
            $errores['password'] = $err;
        }

        if ($err = Validacion::edadValida($datos['fecha_nacimiento'])) {
            $errores['fecha_nacimiento'] = $err;
        }

        if ($err = Validacion::imagenValida($archivoAvatar)) {
            $errores['avatar'] = $err;
        }

        if (empty($datos['sexo'])) {
            $errores['sexo'] = "Debe seleccionar un sexo.";
        }

        if (empty($datos['privacidad'])) {
            $errores['privacidad'] = "Debe seleccionar una privacidad.";
        }

        return $errores;
    }
}
