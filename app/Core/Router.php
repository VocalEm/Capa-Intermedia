<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($route, $controllerAction, $middleware = null)
    {
        $this->routes[] = ['method' => 'GET', 'route' => $route, 'controllerAction' => $controllerAction, 'middleware' => $middleware];
    }

    public function post($route, $controllerAction, $middleware = null)
    {
        $this->routes[] = ['method' => 'POST', 'route' => $route, 'controllerAction' => $controllerAction, 'middleware' => $middleware];
    }

    public function dispatch()
    {
        $uri = rtrim($_SERVER['REQUEST_URI'], '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($method == $route['method'] && preg_match('#^' . $route['route'] . '$#', $uri)) {
                // Verificar si hay middleware
                if ($route['middleware']) {
                    $middleware = 'App\\Middlewares\\' . ucfirst($route['middleware']);
                    (new $middleware())->handle();  // Ejecutar el middleware
                }

                // Separar controlador y acción
                list($controller, $action) = explode('@', $route['controllerAction']);
                $controllerClass = 'App\\Controllers\\' . $controller;
                $controllerInstance = new $controllerClass();
                $controllerInstance->$action();
                return;
            }
        }

        // Si no encontramos la ruta, lanzar un error 404
        http_response_code(404);
        echo "Página no encontrada";
    }
}
