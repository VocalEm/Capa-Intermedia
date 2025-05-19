<?php

use App\Core\Router;

$router = new Router();

//ruta para servri imagenes 
$router->get('/uploads/{filename}', 'ArchivoController@mostrar');

// Rutas públicas (sin middleware)
//Inico Sesion - usuarios no autenticados
$router->get('/', 'InicioSesionController@index', 'guest');  // Página pública
$router->get('/inicio_sesion', 'InicioSesionController@mostrarInicioSesion', 'guest');  // muestra inicio de sesion
$router->post('/login', 'InicioSesionController@login',  'guest');  // Maneja el inicio de sesión
$router->post('/registro', 'InicioSesionController@registrar',  'guest');  // Maneja el registro de usuario

//rutas para usuarios autenticados
$router->get('/logout', 'CerrarSesionController@cerrarSesion',  'auth'); //ruta para cerrar sesion
$router->get('/home', 'HomeController@index',  'auth');
$router->get('/perfil', 'PerfilController@mostrarPerfilUsuarioSesion',  'auth'); // Usuario en sesion

// Ruta para cargar la vista de administración
$router->get('/admin', 'HomeController@mostrarVistaAdmin', 'admin');

// Rutas AJAX para operaciones específicas
$router->get('/admin/pendientes', 'HomeController@obtenerProductosPendientes', 'admin');
$router->post('/admin/aprobar', 'HomeController@aprobarProducto', 'admin');
$router->post('/admin/rechazar', 'HomeController@rechazarProducto', 'admin');

//rutas para compradores
$router->post('/admin/rechazar', 'HomeController@rechazarProducto', 'admin'); //ruta para rechazar producto
$router->post('/admin/aprobar', 'HomeController@aprobarProducto', 'admin'); //ruta para aprobar producto
$router->get('/admin/pendientes', 'HomeController@obtenerProductosPendientes', 'admin'); //ruta para ver productos pendientes

$router->get('/superadmin/home', 'HomeController@mostrarPanelAdministracion', 'superadmin'); //home super admin 
$router->post('/superadmin/agregar', 'HomeController@agregarAdministrador', 'superadmin'); //ruta para agregar admin
$router->post('/superadmin/eliminar', 'HomeController@eliminarAdministrador', 'superadmin'); //ruta para eliminar admin

//rutas para compradores
$router->get('/perfil/{id}', 'PerfilController@mostrarPerfilUsuario',  'comprador'); // otro Usuario
$router->post('/perfil/crear-lista', 'PerfilController@crearLista',  'comprador'); // Crear lista de usuario comprador
$router->get('/perfil/eliminar-lista/{id}', 'PerfilController@eliminarLista', 'comprador'); // crear lista usuario comprador
$router->get('/catalogo', 'CatalogoController@mostrarCatalogo',  'comprador'); //catalogo de productos
$router->get('/catalogo/filtros', 'CatalogoController@mostrarPorFiltros', 'comprador'); // catalogo con filtros
$router->get('/producto/{id}', 'ProductoController@mostrarProducto', 'comprador'); // vista prodcuto
$router->get('/producto/lista/{idLista}/{idProducto}', 'ProductoController@productoAgregarLista', 'comprador'); // agrega producto a lista
$router->get('/lista/{idLista}', 'ListaDetalleController@mostrarListasDetalle', 'comprador'); // muestra lista especifica
$router->get('/lista/eliminar/{idLista}/{idProducto}', 'ListaDetalleController@eliminarProducto', 'comprador'); // elimina articulo de lista
$router->get('/carrito', 'CarritoController@mostrarCarrito', 'comprador'); // muestra  carrito
$router->get('/carrito/aumentar/{idProducto}', 'CarritoController@aumentarCantidad', 'comprador'); // aumenta cantidad de producto  carrito
$router->get('/carrito/reducir/{idProducto}', 'CarritoController@reducirCantidad', 'comprador'); // reduce cantidad de producto  carrito  carrito
$router->post('/carrito/agregar/{idProducto}', 'CarritoController@agregarProducto', 'comprador'); // agrega producto a carrito
$router->get('/carrito/eliminar/{idProducto}', 'CarritoController@eliminarProducto', 'comprador'); // elimina producto de carrito
$router->get('/pago', 'PagoController@mostrarPago', 'comprador'); // entra a paserela de pago
$router->post('/pago/procesar', 'PagoController@procesarPago', 'comprador'); // entra a paserela de pago
$router->get('/buscar', 'BuscarUsuarioController@mostrarBusqueda', 'comprador'); // entra a paserela de pago



//rutas para vendedores
$router->post('/agregar-producto', 'AgregarProductoController@agregarProducto', 'vendedor'); // crear solicitud de producto 
$router->get('/agregar-producto', 'AgregarProductoController@mostrarFormulario', 'vendedor'); // muestra pagina de producto
$router->post('/agregar-producto/categoria', 'AgregarProductoController@agregarCategoria', 'vendedor'); // muestra pagina de producto
$router->get('/producto/editar/{id}', 'ProductoController@mostrarEditar', 'vendedor'); // muestra pagina de producto
$router->post('/producto/actualizar/{id}', 'ProductoController@actualizarProducto', 'vendedor'); // muestra pagina de producto
$router->get('/producto/eliminar/{id}', 'ProductoController@eliminarProducto', 'vendedor'); // muestra pagina de producto










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
