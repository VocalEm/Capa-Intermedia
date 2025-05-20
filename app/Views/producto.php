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
            <?php
            if ($producto['TIPO_PUBLICACION'] == 'venta'):
            ?>
            action="/carrito/agregar/<?= $producto['ID'] ?>"
            <?php
            else :
            ?>
            action="/chat/crearChat/<?= $producto['ID_VENDEDOR'] ?>"
            <?php
            endif;
            ?>
            method="POST">
            <h2>
                <?= $producto['NOMBRE']; ?>
                <button class="btn-wishlist" id="save-button">
                    <i style="color: purple;" id="saveIcon" class="fa-regular fa-bookmark fa-2x <?php if ($isGuardado) echo 'guardado' ?>"></i>
                </button>
            </h2>
            <p style="font-weight:bold; color:goldenrod; font-size: 2rem; margin:0;">Promedio: <?= number_format($promedioValoracion['promedio_valoracion'], 1); ?> ★</p>
            <div class="descripcion-container">
                <p style="font-weight: bold; font-size:1.4rem;" class="descripcion">
                    <?= $producto['DESCRIPCION'] ?>
                </p>
            </div>

            <p style="font-weight: bold; font-size:1.4rem;" class="precio"><?= $producto['TIPO_PUBLICACION'] == 'venta' ?  "Precio: $" . $producto['PRECIO'] : 'Cotizacion' ?></p>
            <p style="font-weight: bold; font-size:1.4rem;" class="stock">Stock disponible: <?= $producto['TIPO_PUBLICACION'] !==  'cotizacion' ?  $producto['STOCK'] : 'Por Pedido'  ?></p>
            <input type="hidden" name="idProducto" value="<?= $producto['ID'] ?>">
            <input type="hidden" name="tipoPublicacion" value="<?= $producto['TIPO_PUBLICACION'] ?>">
            <?php
            if ($producto['TIPO_PUBLICACION'] == 'venta'):
                if ($producto['STOCK'] > 0):
            ?>
                    <button type="submit" class="btn-cotizar"><?= $producto['TIPO_PUBLICACION'] == 'venta' ?  "Agregar al carrito" : 'Cotizar'  ?></button>
                <?php
                else:
                ?>
                    <h3 style="color: red; font-size:2rem;">NO STOCK SUFICIENTE!!</h3>
                <?php
                endif;
            else:
                ?>
                <button type="submit" class="btn-cotizar"><?= $producto['TIPO_PUBLICACION'] == 'venta' ?  "Agregar al carrito" : 'Cotizar'  ?></button>
            <?php
            endif;
            ?>

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
        <div class="valoracion-comentarios">

            <div style="font-weight: bold; font-size:1.4rem;" class="lista-comentarios">
                <h4>Comentarios:</h4>
                <?php
                foreach ($valoraciones as $valoracion):
                ?>
                    <ul>
                        <li style="color:gray;">

                            <strong style="color:black;"><?= $valoracion['USERNAME'] ?> :</strong>
                            <br>
                            <strong style="color:black;"><?= $valoracion['PUNTUACION'] ?> ★</strong>
                            <?= $valoracion['COMENTARIO'] ?>
                        </li>

                    </ul>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>

    <!-- Ventana emergente para seleccionar wishlist -->
    <!-- Ventana emergente para seleccionar wishlist -->
    <div id="popup" class="popup" style="display: none;">
        <div class="popup-content">
            <button class="close-button" aria-label="Cerrar ventana emergente">&times;</button>
            <h2>Selecciona una Wishlist</h2>
            <ul>
                <?php foreach ($listas as $lista): ?>
                    <a href="/producto/lista/<?= $lista['ID'] ?>/<?= $producto['ID'] ?>">
                        <li class="wishlist-item" data-id="<?= $lista['ID']; ?>">
                            <img src="/uploads/<?= $lista['IMAGEN']; ?>" alt="<?= $lista['NOMBRE']; ?>" class="wishlist-img">
                            <span class="wishlist-name"><?= $lista['NOMBRE']; ?></span>
                        </li>
                    </a>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>



    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>



    <script src="/js/producto.js"></script>
    <script src="/js/listaspopup.js"></script>





</body>

</html>