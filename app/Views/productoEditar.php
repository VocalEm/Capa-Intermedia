<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="isla-producto">
        <form class="producto-info"
            action="/producto/actualizar/<?= $producto['ID'] ?>"
            method="POST">

            <h2>
                <?= htmlspecialchars($producto['NOMBRE']); ?>
            </h2>

            <div class="descripcion-container">
                <p class="descripcion">
                    <?= htmlspecialchars($producto['DESCRIPCION']) ?>
                </p>
            </div>

            <p class="precio">
                <?= $producto['TIPO_PUBLICACION'] == 'venta' ? "Precio: $" . number_format($producto['PRECIO'], 2) : 'Cotización' ?>
            </p>

            <p class="stock">Stock disponible:
                <?= $producto['TIPO_PUBLICACION'] == 'venta' ? $producto['STOCK'] . ' unidades' : 'Por cotización' ?>
            </p>

            <!-- Inputs para modificar precio y stock (solo para productos en venta) -->
            <?php if ($producto['TIPO_PUBLICACION'] == 'venta'): ?>
                <div class="form-group">
                    <label for="precio">Modificar Precio</label>
                    <input type="number" name="precio" id="precio" value="<?= $producto['PRECIO'] ?>" step="0.01" min="0">
                </div>

                <div class="form-group">
                    <label for="stock">Modificar Stock</label>
                    <input type="number" name="stock" id="stock" value="<?= $producto['STOCK'] ?>" min="0">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <button type="submit" class="btn-modificar">Actualizar</button>
            </div>

        </form>


        <div class="producto-media">
            <!-- Galería -->
            <div class="galeria">
                <div class="galeria-contenedor">
                    <?php foreach ($producto['multimedia'] as $multimedia): ?>
                        <?php $ext = pathinfo($multimedia, PATHINFO_EXTENSION); ?>
                        <?php if ($ext === 'mp4'): ?>
                            <video src="/uploads/<?= $multimedia ?>" class="media-item" onclick="mostrarEnFoco(this, 'video')"></video>
                        <?php else: ?>
                            <img src="/uploads/<?= $multimedia ?>" class="media-item" onclick="mostrarEnFoco(this, 'imagen')" />
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <button class="flecha izquierda" onclick="scrollGaleria('izquierda')">◀</button>
                <button class="flecha derecha" onclick="scrollGaleria('derecha')">▶</button>
            </div>

            <!-- Contenedor de enfoque -->
            <div class="multimedia-focus" id="focusContainer">
                <img src="" id="focusImage" class="focus-item" style="display: none;">
                <video src="" id="focusVideo" class="focus-item" controls style="display: none;"></video>
            </div>
        </div>
        <!-- ⭐ Sección de valoración y comentarios -->

    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script src="/js/producto.js"></script>
    <script src="/js/listaspopup.js"></script>



</body>

</html>