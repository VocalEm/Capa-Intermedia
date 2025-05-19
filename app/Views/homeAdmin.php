<?php

use App\Middlewares\AuthMiddleware;

require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="productos-pendientes">
        <h2>Productos Pendientes de Aprobar</h2>

        <div class="productos-grid">
            <!-- Producto 1 -->


        </div>
    </section>


    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Función para obtener productos pendientes
            function obtenerProductosPendientes() {

                // Realizamos la petición AJAX a la ruta '/admin/pendientes'
                fetch('/admin/pendientes', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json()) // Convertimos la respuesta a JSON
                    .then(data => {
                        console.log(data); // Mostrar la respuesta completa en consola para depuración

                        // Verificamos si la respuesta tiene status success y contiene productos
                        if (data.status === 'success' && data.productos.length > 0) {
                            actualizarVistaProductos(data.productos); // Pasamos el array de productos
                        } else {
                            // Si no hay productos, limpiamos el contenedor
                            document.querySelector('.productos-grid').innerHTML = '<p>No hay productos pendientes.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los productos pendientes:', error);
                    });
            }

            // Función para actualizar la vista de productos
            function actualizarVistaProductos(productos) {
                const contenedor = document.querySelector('.productos-grid');

                // Limpiamos el contenedor antes de insertar nuevos productos
                contenedor.innerHTML = '';

                // Iteramos sobre cada producto y creamos su estructura HTML
                productos.forEach(producto => {

                    // Comprobamos si el producto tiene imágenes
                    const imagenes = producto.multimedia.length > 0 ? producto.multimedia.filter(item => item.endsWith('.jpg') || item.endsWith('.png') || item.endsWith('.webp')) : [];
                    const video = producto.multimedia.find(item => item.endsWith('.mp4'));
                    if (producto.PRECIO == null)
                        producto.PRECIO = "Cotizacion";

                    // Usamos la primera imagen disponible o una imagen por defecto
                    const imagenPrincipal = imagenes.length > 0 ? `/uploads/${imagenes[0]}` : 'src/img/default-product.jpg';

                    const productoHTML = `
                <div class="producto-tarjeta" data-id="${producto.ID}">
                    <img src="${imagenPrincipal}" alt="${producto.NOMBRE}" class="producto-imagen" />

                    <div class="producto-info">
                        <p class="producto-nombre"><strong>${producto.NOMBRE}</strong></p>
                        <div class="producto-descripcion-container">
                        <p class="producto-descripcion">${producto.DESCRIPCION}</p>
                        </div>
                        <p><strong>Precio:</strong> $${producto.PRECIO}</p>
                        <p><strong>Stock:</strong> ${producto.STOCK}</p>
                        <p><strong>Vendedor:</strong> ${producto.vendedor_username} (${producto.vendedor_correo})</p>
                        <p><strong>Categorías:</strong> ${producto.categorias.join(', ')}</p>
                        
                        <div class="acciones">
                            <form action="/admin/aprobar" method="POST">
                                <input type="hidden" name="producto_id" value="${producto.ID}" />
                                <button type="submit" class="btn-aprobar">Aprobar</button>
                            </form>
                            <form action="/admin/rechazar" method="POST">
                                <input type="hidden" name="producto_id" value="${producto.ID}" />
                                <button type="submit" class="btn-rechazar">Rechazar</button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
                    // Insertamos el producto en el contenedor
                    contenedor.insertAdjacentHTML('beforeend', productoHTML);
                });
            }

            // Llamamos a la función al cargar la página
            obtenerProductosPendientes();

            // Establecemos un intervalo para actualizar la vista cada 5 segundos
            setInterval(obtenerProductosPendientes, 5000);
        });
    </script>


</body>

</html>