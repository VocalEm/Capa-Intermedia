<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <section class="pago-section">
        <div class="container">
            <h2>Proceso de Pago</h2>
            <form action="/pago/procesar" method="POST" class="form-pago">
                <div class="form-group">
                    <label for="numero_tarjeta">Nombre de Tarjeta</label>
                    <input type="text" name="nombre" id="numero_tarjeta" placeholder="Nombre de Tarjeta" required>
                </div>
                <div class="form-group">
                    <label for="numero_tarjeta">Direccion</label>
                    <input type="text" name="direccion" id="numero_tarjeta" placeholder="Direccion" required>
                </div>

                <div class="form-group">
                    <label for="numero_tarjeta">Número de Tarjeta</label>
                    <input type="text" name="numero_tarjeta" id="numero_tarjeta" placeholder="0000 0000 0000 0000" required>
                </div>

                <div class="form-group">
                    <label for="fecha_expiracion">Fecha de Expiración</label>
                    <div class="fecha-expiracion">
                        <input type="text" name="mes" id="fecha_expiracion" placeholder="MM" required>
                        <input type="text" name="year" id="fecha_expiracion" placeholder="AA" required>
                    </div>

                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="password" name="cvv" id="cvv" placeholder="123" required>
                </div>

                <div class="form-group">
                    <label for="monto">Monto a Pagar</label>
                    <h2>$<?= $total ?></h2>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-pagar">Pagar</button>
                </div>
            </form>
        </div>
    </section>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>
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