<?php
// Incluir el archivo del Router
require_once __DIR__ . '/app/core/Router.php';

$router = new Router($_SERVER['REQUEST_URI']);
$router->enrutar();
