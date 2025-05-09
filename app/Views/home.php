<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>



    <section class="mas-vendidos">
        <h2 class="titulo-seccion">Los más vendidos</h2>
        <div class="carrusel-container">
            <button class="carrusel-btn left" onclick="moverCarrusel(-1)">&#10094;</button>

            <div class="carrusel" id="carrusel">

                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>

                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>
                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>

            </div>

            <button class="carrusel-btn right" onclick="moverCarrusel(1)">&#10095;</button>
        </div>
    </section>

    <section class="banner-promocional">
        <div class="banner-contenido">
            <h2>¡Ofertas especiales por tiempo limitado!</h2>
            <p>Descubre productos con grandes descuentos seleccionados para ti.</p>
            <a href="#" class="btn-banner">Ver Ofertas</a>
        </div>
    </section>

    <section class="mas-vendidos">
        <h2 class="titulo-seccion">Seleccionados por nosotros, para ti</h2>
        <div class="carrusel-container">
            <button class="carrusel-btn left" onclick="moverCarrusel2(-1)">&#10094;</button>

            <div class="carrusel" id="carrusel2">

                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>

                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>
                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>Descripción breve del producto más vendido.</p>
                    <span class="precio">$199.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>Alta demanda en nuestra tienda online.</p>
                    <span class="precio">$249.99</span>
                </a>


                <a href="#" class="tarjeta-producto">
                    <img src="/assets/producto.jpg" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>Ideal para tu día a día.</p>
                    <span class="precio">$129.00</span>
                </a>

            </div>

            <button class="carrusel-btn right" onclick="moverCarrusel2(1)">&#10095;</button>
        </div>
    </section>

    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script src="/js/home.js"></script>
</body>

</html>