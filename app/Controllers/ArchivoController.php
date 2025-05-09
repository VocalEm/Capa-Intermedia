<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;

class ArchivoController
{
    public function mostrar($filename)
    {
        // Construir la ruta correcta
        $ruta = __DIR__ . '/../uploads/' . $filename;

        // Verificación del usuario logueado
        UsuarioSesion::iniciar();
        $usuario = UsuarioSesion::obtener();

        if (!$usuario) {
            http_response_code(403);
            echo "Acceso denegado - No estás autenticado.";
            exit;
        }

        // Verificar que el archivo exista
        if (!file_exists($ruta)) {
            http_response_code(404);
            echo "Archivo no encontrado: " . $filename;
            exit;
        }

        // Obtener el tipo MIME del archivo
        $mime = mime_content_type($ruta);

        // Enviar headers adecuados
        header("Content-Type: " . $mime);
        header("Content-Length: " . filesize($ruta));
        header("Cache-Control: public, max-age=3600");
        header("Content-Disposition: inline; filename=\"" . basename($ruta) . "\"");

        // Enviar el contenido del archivo
        readfile($ruta);
        exit;
    }
}
