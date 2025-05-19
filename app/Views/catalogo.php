<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="catalogo-aside">
        <aside class="lista-tarjeta catalogo-categorias agregar-producto">
            <form class="categorias-container" action="/catalogo/filtros" method="GET">
                <h3>Filtros</h3>
                <div class='categorias-descripcion'>
                    <input type="text" name="descripcion" value="<?= $_GET['descripcion'] ?? "" ?>" placeholder="Buscar por descripcion">
                </div>
                <div class="categorias-lista">
                    <?php
                    $categoriasSeleccionadas = $_GET['categorias'] ?? [];

                    foreach ($categorias as $categoria):
                        $checked = in_array($categoria['ID'], $categoriasSeleccionadas) ? 'checked' : '';
                    ?>
                        <label>
                            <input type="checkbox" name="categorias[]" value="<?= $categoria['ID'] ?>" <?= $checked ?>>
                            <?= htmlspecialchars($categoria['TITULO'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <button type="submit">Buscar por categoría</button>
            </form>
        </aside>

        <div class="lista-tarjeta catalogo-articulos">
            <div class="tarjetas-producto">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <a class="tarjeta-producto" href="/producto/<?= $producto['ID'] ?>">
                            <img src="/uploads/<?= $producto['multimedia'][0] ?? 'default.jpg' ?>" alt="Producto" />
                            <h3><?= $producto['NOMBRE'] ?></h3>
                            <p><?= htmlspecialchars($producto['vendedor_username'], ENT_QUOTES, 'UTF-8') ?></p>
                            <span class="precio">
                                <?= $producto['TIPO_PUBLICACION'] == 'venta' ?  '$' . $producto['PRECIO'] : 'Cotizacion'  ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron productos para las categorías seleccionadas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>
        //alerta de exito en caso de exito de registro
        <?php
        if (isset($_SESSION['exito'])):
            $mensaje = $_SESSION['exito'];
            unset($_SESSION['exito']); ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= $mensaje ?>',
                confirmButtonColor: '#3085d6', // Este color se puede mantener para el borde
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-swal-button'
                }
            });
        <?php endif; ?>

        <?php
        if (isset($_SESSION['errores'])):
            $mensaje  = $_SESSION['errores'];
            unset($_SESSION['errores']); ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= $mensaje ?>',
                confirmButtonColor: '#dc2626', // Este color se puede mantener para el borde
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-swal-button'
                }
            });
        <?php
        endif;
        ?>
    </script>

</body>

</html>