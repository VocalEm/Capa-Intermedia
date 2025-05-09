<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <div class="lista-tarjeta">
        <div class="filtro-categorias" style="margin: 1rem 0">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="todos">Todos</option>
                <option value="electronica">Electrónica</option>
                <option value="ropa">Ropa</option>
                <option value="hogar">Hogar</option>
                <option value="juguetes">Juguetes</option>
            </select>
        </div>

        <!-- Tarjetas de productos -->
        <div class="tarjetas-producto">
            <!-- Aquí irán las tarjetas de productos dinámicamente o estáticamente -->
            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>

            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>

            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>

            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>

            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>

            <div class="tarjeta-producto">
                <img src="src/img/producto.jpg" alt="Producto 1" />
                <h3>Producto 1</h3>
                <p>Descripción breve del producto más vendido.</p>
                <span class="precio">$199.99</span>
            </div>
            <!-- Agrega más tarjetas según sea necesario -->
        </div>
    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>
</body>

</html>