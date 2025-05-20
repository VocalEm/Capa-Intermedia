<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <div class="lista-tarjeta ">
        <h2 class="titulo-lista"><?= $lista[0]['NOMBRE'] ?></h2>
        <h3 class="titulo-autor">Autor: <?= $lista[0]['USUARIO'] ?></h3>
        <div class="tarjetas-producto">

            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="tarjeta-producto" href="/producto/<?= $producto['ID'] ?>">
                        <a href="/producto/<?= $producto['ID'] ?>" class="tarjeta-producto-link">
                            <img src="/uploads/<?= $producto['multimedia'][0] ?? 'default.jpg' ?>" alt="Producto" />
                            <h3><?= $producto['NOMBRE'] ?></h3>
                            <p><?= htmlspecialchars($producto['vendedor_username'], ENT_QUOTES, 'UTF-8') ?></p>
                            <span class="precio">
                                <?= $producto['TIPO_PUBLICACION'] == 'venta' ? '$' . $producto['PRECIO'] : 'Cotizacion' ?>
                            </span>
                        </a>
                        <?php
                        if ($lista[0]['ID_USUARIO'] == $_SESSION['usuario']['id']): ?>
                            <a href="/lista/eliminar/<?= $lista[0]['ID'] ?>/<?= $producto['ID'] ?>" class="tarjeta-producto-boton">Eliminar</a>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron productos en esta lista.</p>
            <?php endif; ?>
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