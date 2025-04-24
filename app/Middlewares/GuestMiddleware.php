<?php

namespace App\Middlewares;

class GuestMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            header('Location: /home');
            exit;
        }
    }
}
