<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="isla-carrito">
        <h2>Carrito de Compras</h2>

        <div class="carrito-contenido">
            <?php
            $total = 0;
            $subtotal = 0;
            $iva = 0;
            foreach ($productos as $producto):
                if ($producto['PRECIO'] == 0) {
                    $producto['PRECIO'] = $producto['PRECIO_COTIZACION'];
                }
                $subtotal += ($producto['PRECIO'] * $producto['CANTIDAD']);
                $iva = $subtotal * .16;
                $total = $subtotal + $iva;
            ?>
                <div class="producto-carrito">
                    <img
                        src="/uploads/<?= $producto['multimedia'][0] ?>"
                        alt="Silla Ergonómica"
                        class="producto-imagen" />
                    <div class="producto-detalles">
                        <div class="producto-action">
                            <p class="producto-nombre"><strong><?= $producto['NOMBRE'] ?></strong></p>
                            <a href="/carrito/eliminar/<?= $producto['ID'] ?>"><i class="fa-solid fa-trash fa-2x"></i></a>
                        </div>

                        <p class="producto-descripcion">
                            <?= $producto['DESCRIPCION'] ?>
                        </p>
                        <div class="producto-precio-cantidad">
                            <p class="producto-precio">Precio: $<?= $producto['PRECIO'] ?></p>
                            <div class="producto-cantidad">
                                <a href="/carrito/reducir/<?= $producto['ID'] ?>">-</a>
                                <input disabled type="number" value="<?= $producto['CANTIDAD'] ?>" max="<?= $producto['STOCK'] ?>" min="1" class="cantidad-input" />
                                <a href="/carrito/aumentar/<?= $producto['ID'] ?>">+</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>

        </div>

        <!-- Total y Botón de Pago -->
        <form class="total-carrito" method="GET" action="/pago">
            <p><strong>Subtotal:</strong> $<?= $subtotal ?></p>
            <p><strong>IVA:</strong> $<?= $iva ?></p>
            <p><strong>Total:</strong> $<?= $total ?></p>
            <input type="hidden" value="<?= $total ?>" name="total">
            <button type="submit" class="btn-pago">Proceder al Pago</button>
        </form>
    </section>


    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>
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