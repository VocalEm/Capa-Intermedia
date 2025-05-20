<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="pago-section">
        <div class="container" style="max-width:400px;margin:2rem auto;background:#fff;padding:2rem;border-radius:1rem;box-shadow:0 2px 16px #0002;">
            <h2>Pago en Efectivo</h2>
            <p style="font-size: 1.2rem; color:black; font-weight:bold;">Para completar tu compra, descarga tu comprobante y acude a la tienda a pagar.</p>
            <p style="font-size: 1.2rem; color:black; font-weight:bold;"><strong>Monto a pagar:</strong> $<?= isset($total) ? $total : '' ?></p>
            <?php if (isset($ordenId) && isset($total)): ?>
                <a href="/pago/descargarComprobante/<?= $ordenId ?>/<?= $total ?>" class="btn-pagar" style="display:block;text-align:center;margin-top:2rem;">Descargar comprobante PDF</a>
            <?php endif; ?>
            <a href="/home" class="btn-regresar-efectivo" style="display:block;text-align:center;margin-top:1.5rem;">Regresar</a>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>
    <script>
        <?php if (isset($ordenId) && isset($total)): ?>
            // Descarga automática del comprobante PDF y redirección a valoración
            window.onload = function() {
                // Abrir el PDF en una nueva pestaña
                window.open("/pago/descargarComprobante/<?= $ordenId ?>/<?= $total ?>", "_blank");
                // Redirigir a la valoración después de un breve delay
                setTimeout(function() {
                    window.location.href = "/valoracion/mostrarValoracion/<?= $ordenId ?>";
                }, 1000);
            };
        <?php endif; ?>

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