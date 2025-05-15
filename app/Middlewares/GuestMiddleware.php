<?php

namespace App\Middlewares;

class GuestMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario']) || isset($_COOKIE['TOKEN'])) {
            header('Location: /home');
            exit;
        }
    }
}
