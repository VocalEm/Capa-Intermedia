<?php

use App\Core\Router;

$router = new Router();

//ruta para servri imagenes 
$router->get('/uploads/{filename}', 'ArchivoController@mostrar');

// Rutas públicas (sin middleware)
//Inico Sesion - usuarios no autenticados
$router->get('/', 'InicioSesionController@index', 'guest');  // Página pública
$router->get('/inicio_sesion', 'InicioSesionController@mostrarInicioSesion', 'guest');  // Página pública
$router->post('/login', 'InicioSesionController@login',  'guest');  // Maneja el inicio de sesión
$router->post('/registro', 'InicioSesionController@registrar',  'guest');  // Maneja el registro de usuario

//usuario autenticado basico vendedor o comprador
$router->get('/home', 'HomeController@index',  'auth');  // Maneja el cierre de sesión

//ruta a perfil de usuario
$router->get('/perfil', 'PerfilController@mostrarPerfilUsuarioSesion',  'auth'); // Usuario en sesion
$router->get('/perfil/{id}', 'PerfilController@mostrarPerfilUsuario',  'auth'); // otro Usuario

$router->post('/perfil/crear-lista', 'PerfilController@crearLista',  'auth'); // Crear lista de usuario comprador
$router->get('/perfil/eliminar-lista/{id}', 'PerfilController@eliminarLista', 'auth'); // crear lista usuario comprador

$router->post('/agregar-producto', 'AgregarProductoController@agregarProducto', 'auth'); // crear solicitud de producto 
$router->get('/agregar-producto', 'AgregarProductoController@mostrarFormulario', 'auth'); // muestra pagina de producto
$router->post('/agregar-producto/categoria', 'AgregarProductoController@agregarCategoria', 'auth'); // muestra pagina de producto



//ruta para cerrar sesion
$router->get('/logout', 'CerrarSesionController@cerrarSesion',  'auth');

//catalogo de productos
$router->get('/catalogo', 'CatalogoController@mostrarCatalogo',  'auth');








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
