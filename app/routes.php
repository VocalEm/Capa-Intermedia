<?php

use App\Core\Router;

$router = new Router();

// Rutas públicas (sin middleware)
//Inico Sesion - usuarios no autenticados
$router->get('/', 'InicioSesionController@index', 'guest');  // Página pública
$router->get('/inicio_sesion', 'InicioSesionController@mostrarInicioSesion', 'guest');  // Página pública
$router->post('/login', 'InicioSesionController@login',  'guest');  // Maneja el inicio de sesión
$router->post('/registro', 'InicioSesionController@registrar',  'guest');  // Maneja el registro de usuario

//usuario autenticado basico
$router->get('/home', 'HomeController@index',  'auth');  // Maneja el cierre de sesión


//$router->get('producto/{id}', 'ProductoController@ver');  // Detalles de producto público

// Rutas protegidas por middleware 'auth' (requiere estar logueado)
//$router->get('perfil', 'UserController@perfil', 'auth');  // Requiere autenticación

// Ruta protegida por middleware 'admin' (solo accesible por administradores)
//$router->get('admin/panel', 'AdminController@dashboard', 'admin');  // Requiere ser admin

// Rutas de compra que requieren autenticación
//$router->post('producto/{id}/comprar', 'CompraController@procesar', 'auth');

// Rutas de administración para 'admin'
//$router->get('admin/users', 'AdminController@users', 'admin');

// Retornamos el router
return $router;
