<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <div class="agregar-producto">
        <h2>Agregar Producto</h2>
        <form id="form-agregar-producto">

            <div class="campo">
                <label for="nombre">Nombre del producto:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción del producto:</label>
                <input id="descripcion" name="descripcion" rows="4" required></input>
            </div>

            <div class="campo">
                <label for="stock">Cantidad en stock:</label>
                <input type="number" id="stock" name="stock" min="0" required>
            </div>

            <!-- Selección o creación de categoría -->
            <div class="campo">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" onchange="toggleNuevaCategoria()">
                    <option value="">Selecciona una categoría</option>
                    <option value="electronica">Electrónica</option>
                    <option value="ropa">Ropa</option>
                    <option value="nueva">Agregar nueva categoría</option>
                </select>
            </div>

            <div class="campo" id="nueva-categoria" style="display: none;">
                <label for="nueva_categoria">Nueva categoría:</label>
                <input type="text" id="nueva_categoria" name="nueva_categoria">
            </div>

            <div class="campo">
                <label>Imágenes del producto (hasta 3):</label>
                <input type="file" name="imagenes[]" accept="image/*" multiple required>
            </div>

            <div class="campo">
                <label>Video del producto (opcional):</label>
                <input type="file" name="video" accept="video/*">
            </div>

            <div class="campo">
                <label>Tipo de venta:</label>
                <select id="tipo-venta" name="tipo_venta" required onchange="togglePrecio()">
                    <option value="">Seleccionar...</option>
                    <option value="cotizacion">Por cotización</option>
                    <option value="fijo">Precio fijo</option>
                </select>
            </div>

            <div class="campo" id="campo-precio" style="display: none;">
                <label for="precio">Precio del producto:</label>
                <input type="number" id="precio" name="precio" min="0" step="0.01">
            </div>

            <button type="submit">Guardar producto</button>
        </form>
    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script src="/js/addproducto.js"></script>
</body>

</html>