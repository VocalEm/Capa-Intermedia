<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="agregar-producto">
        <form action="/agregar-producto/categoria" method="POST">
            <div class="campo formulario-agregar" id="nueva-categoria">
                <label for="nueva_categoria">Nueva categoría:</label>
                <input type="text" id="nueva_categoria" name="nueva_categoria" placeholder="Titulo" required>

                <input type="textarea" placeholder="Descripcion" id="nueva_categoria" name="descripcion" required>

                <input type="submit" value="Agregar Categoria" class="nueva_categoria_btn">
            </div>
        </form style="margin-bottom:1rem;">
    </div>

    <div class="agregar-producto">
        <h2>Agregar Producto</h2>
        <form id="form-agregar-producto" method="POST" action="/agregar-producto" enctype="multipart/form-data">

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

            <div class="campo">
                <label>Categorías:</label>
                <div class="categorias-container">
                    <?php
                    foreach ($categorias as $categoria):
                    ?>
                        <label>
                            <input type="checkbox" name="categorias[]" value="<?= $categoria['ID'] ?>"> <?= $categoria['TITULO'] ?>
                        </label>
                    <?php
                    endforeach;
                    ?>

                </div>
            </div>

            <div class="campo">
                <label>Imágenes del producto:</label>
                <div id="imagenes-container" class="imagenes-container">
                    <!-- Aquí se agregan dinámicamente las imágenes cargadas -->
                </div>
                <button type="button" onclick="agregarImagen()">Agregar Imagen</button>
            </div>

            <div class="campo">
                <label style="margin: 1rem 0;">Videos del producto:</label>
                <div id="videos-container" class="videos-container">
                    <!-- Aquí se agregarán los videos dinámicamente -->
                </div>
                <button type="button" onclick="agregarVideo()">Agregar Video</button>
            </div>

            <div class="campo">
                <label style="margin: 1rem 0;">Tipo de venta:</label>
                <select id="tipo-venta" name="tipo_venta" required onchange="togglePrecio()">
                    <option select disabled value="">Seleccionar...</option>
                    <option value="cotizacion">Por cotización</option>
                    <option value="venta">Precio fijo</option>
                </select>
            </div>

            <div class="campo" id="campo-precio" style="display: none;">
                <label for="precio">Precio del producto:</label>
                <input type="number" id="precio" name="precio" min="0" step="0.01">
            </div>

            <button style="margin: 1rem 0;" type="submit">Guardar producto</button>
        </form>
    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['exito'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '<?= $_SESSION['exito']; ?>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
                <?php unset($_SESSION['exito']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Errores en el formulario',
                    html: `<ul><?= implode("", array_map(fn($e) => "<li>$e</li>", $_SESSION['errores'])) ?></ul>`,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Aceptar'
                });
                <?php unset($_SESSION['errores']); ?>
            <?php endif; ?>
        });
    </script>

    <script src="/js/addproducto.js"></script>

</body>

</html>