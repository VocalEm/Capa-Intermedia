<?php

use App\Core\Router;

$router = new Router();

// ===================
// Recursos estáticos
// ===================
$router->get('/uploads/{filename}', 'ArchivoController@mostrar');

// ===================
// Rutas públicas (sin middleware)
// ===================
// Inicio Sesión - usuarios no autenticados
$router->get('/', 'InicioSesionController@index', 'guest');  // Página pública
$router->get('/inicio_sesion', 'InicioSesionController@mostrarInicioSesion', 'guest');  // muestra inicio de sesion
$router->post('/login', 'InicioSesionController@login',  'guest');  // Maneja el inicio de sesión
$router->post('/registro', 'InicioSesionController@registrar',  'guest');  // Maneja el registro de usuario

// ===================
// Rutas de autenticación
// ===================
$router->get('/logout', 'CerrarSesionController@cerrarSesion',  'auth'); //ruta para cerrar sesion
$router->get('/home', 'HomeController@index',  'auth');
$router->get('/perfil', 'PerfilController@mostrarPerfilUsuarioSesion',  'auth'); // Usuario en sesion

// ===================
// Rutas de administración
// ===================
$router->get('/admin', 'HomeController@mostrarVistaAdmin', 'admin');

// Rutas AJAX para operaciones específicas de admin
$router->get('/admin/pendientes', 'HomeController@obtenerProductosPendientes', 'admin');
$router->post('/admin/aprobar', 'HomeController@aprobarProducto', 'admin');
$router->post('/admin/rechazar', 'HomeController@rechazarProducto', 'admin');

// Rutas duplicadas de admin (pueden ser removidas si ya están arriba)
// $router->post('/admin/rechazar', ...)
// $router->post('/admin/aprobar', ...)
// $router->get('/admin/pendientes', ...)

// ===================
// Rutas de superadmin
// ===================
$router->get('/superadmin/home', 'HomeController@mostrarPanelAdministracion', 'superadmin'); //home super admin 
$router->post('/superadmin/agregar', 'HomeController@agregarAdministrador', 'superadmin'); //ruta para agregar admin
$router->post('/superadmin/eliminar', 'HomeController@eliminarAdministrador', 'superadmin'); //ruta para eliminar admin

// ===================
// Rutas de perfil y listas (usuarios autenticados y compradores)
// ===================
$router->get('/perfil/eliminar', 'PerfilController@eliminarPerfil',  'auth'); // otro Usuario
$router->post('/perfil/editar', 'PerfilController@editarPerfil',  'auth'); // otro Usuario
$router->get('/perfil/mostrarEditar', 'PerfilController@mostrarEditarPerfil',  'auth'); // otro Usuario

$router->get('/perfil/{id}', 'PerfilController@mostrarPerfilUsuario',  'comprador'); // otro Usuario
$router->post('/perfil/crear-lista', 'PerfilController@crearLista',  'comprador'); // Crear lista de usuario comprador
$router->get('/perfil/eliminar-lista/{id}', 'PerfilController@eliminarLista', 'comprador'); // crear lista usuario comprador

// ===================
// Rutas de catálogo y productos (comprador)
// ===================
$router->get('/catalogo', 'CatalogoController@mostrarCatalogo',  'comprador'); //catalogo de productos
$router->get('/catalogo/filtros', 'CatalogoController@mostrarPorFiltros', 'comprador'); // catalogo con filtros
$router->get('/producto/{id}', 'ProductoController@mostrarProducto', 'comprador'); // vista prodcuto
$router->get('/producto/lista/{idLista}/{idProducto}', 'ProductoController@productoAgregarLista', 'comprador'); // agrega producto a lista

// ===================
// Rutas de listas (comprador)
// ===================
$router->get('/lista/{idLista}', 'ListaDetalleController@mostrarListasDetalle', 'comprador'); // muestra lista especifica
$router->get('/lista/eliminar/{idLista}/{idProducto}', 'ListaDetalleController@eliminarProducto', 'comprador'); // elimina articulo de lista

// ===================
// Rutas de carrito (comprador)
// ===================
$router->get('/carrito', 'CarritoController@mostrarCarrito', 'comprador'); // muestra  carrito
$router->get('/carrito/aumentar/{idProducto}', 'CarritoController@aumentarCantidad', 'comprador'); // aumenta cantidad de producto  carrito
$router->get('/carrito/reducir/{idProducto}', 'CarritoController@reducirCantidad', 'comprador'); // reduce cantidad de producto  carrito  carrito
$router->post('/carrito/agregar/{idProducto}', 'CarritoController@agregarProducto', 'comprador'); // agrega producto a carrito
$router->get('/carrito/eliminar/{idProducto}', 'CarritoController@eliminarProducto', 'comprador'); // elimina producto de carrito

// ===================
// Rutas de pago (comprador)
// ===================
$router->get('/pago', 'PagoController@mostrarPago', 'comprador'); // entra a paserela de pago
$router->get('/pago/tarjeta/{total}', 'PagoController@mostrarFormularioPagoTarjeta', 'comprador'); // entra a paserela de pago
$router->get('/pago/efectivo/{total}', 'PagoController@mostrarFormularioPagoEfectivo', 'comprador'); // entra a paserela de pago
$router->get('/pago/paypal/{total}', 'PagoController@mostrarFormularioPagoPaypal', 'comprador'); // entra a paserela de pago
$router->get('/pago/descargarComprobante/{ordenId}/{total}', 'PagoController@descargarComprobanteEfectivo', 'comprador'); // descarga comprobante pago efectivo

$router->post('/pago/procesar', 'PagoController@procesarPago', 'comprador'); // entra a paserela de pago
$router->post('/pago/procesarEfectivo', 'PagoController@procesarPagoEfectivo', 'comprador'); // pago efectivo
$router->get('/pago/efectivo/{ordenId}/{total}', 'PagoController@mostrarFormularioPagoEfectivo', 'comprador'); // mostrar comprobante efectivo
$router->get('/pago/procesarPaypal', 'PagoController@procesarPagoPaypal', 'comprador'); // pago con paypal

// ===================
// Rutas de búsqueda y categorías (comprador y auth)
// ===================
$router->get('/buscar', 'BuscarUsuarioController@mostrarBusqueda', 'comprador'); // entra a paserela de pago
$router->get('/buscar/usuarios', 'BuscarUsuarioController@buscarUsuarios', 'comprador'); // entra a paserela de pago
$router->get('/categorias/lista', 'CategoriasController@mostrarCategorias', 'auth'); // entra a paserela de pago

// ===================
// Rutas de chat y cotización (comprador y auth)
// ===================
$router->post('/chat/crearChat/{idVendedor}', 'CotizacionController@crearChat', 'comprador'); // entra a paserela de pago
$router->get('/chat', 'CotizacionController@mostrarChats', 'auth'); // entra a paserela de pago
$router->get('/chat/{idChat}', 'CotizacionController@mostrarChat', 'auth'); // entra a paserela de pago
$router->post('/chat/enviarMensaje', 'CotizacionController@enviarMensaje', 'auth'); // entra a paserela de pago
$router->post('/chat/crearOferta', 'CotizacionController@crearOferta', 'auth'); // entra a paserela de pago
$router->get('/chat/rechazarOferta/{idchat}', 'CotizacionController@rechazarOferta', 'comprador'); // entra a paserela de pago
$router->post('/chat/aceptarOferta', 'CotizacionController@aceptarOferta', 'comprador'); // entra a paserela de pago
$router->get('/chat/mensajesOferta/{id}', 'CotizacionController@obtenerMensajesOferta', 'auth'); // entra a paserela de pago

// ===================
// Rutas de valoraciones (comprador)
// ===================
$router->get('/valoracion/mostrarValoracion/{idVenta}', 'ValoracionController@mostrarValoracion', 'comprador'); // entra a paserela de pago
$router->post('/valoracion/valorarProductos', 'ValoracionController@valorarProductos', 'comprador'); // entra a paserela de pago

// ===================
// Rutas de productos (vendedor)
// ===================
$router->post('/agregar-producto', 'AgregarProductoController@agregarProducto', 'vendedor'); // crear solicitud de producto 
$router->get('/agregar-producto', 'AgregarProductoController@mostrarFormulario', 'vendedor'); // muestra pagina de producto
$router->post('/agregar-producto/categoria', 'AgregarProductoController@agregarCategoria', 'vendedor'); // muestra pagina de producto
$router->get('/producto/editar/{id}', 'ProductoController@mostrarEditar', 'vendedor'); // muestra pagina de producto
$router->post('/producto/actualizar/{id}', 'ProductoController@actualizarProducto', 'vendedor'); // muestra pagina de producto
$router->get('/producto/eliminar/{id}', 'ProductoController@eliminarProducto', 'vendedor'); // muestra pagina de producto

return $router;
