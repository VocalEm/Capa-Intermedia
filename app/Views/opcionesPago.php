<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="pago-section" style="background: #f5f5f5;">
        <div class="opciones-pago-container">
            <h2>Elige tu método de pago</h2>
            <div class="opciones-pago-form">
                <a href="/pago/tarjeta/<?= $total ?>">
                    <i class="fa-regular fa-credit-card fa-lg"></i> Tarjeta de crédito/débito
                </a>
                <a href="/pago/paypal/<?= $total ?>">
                    <i class="fa-brands fa-paypal fa-lg" style="color:#003087"></i> PayPal
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('efectivo-form').submit();">
                    <i class="fa-solid fa-money-bill-wave fa-lg" style="color:#22c55e"></i> Efectivo
                </a>
                <form id="efectivo-form" action="/pago/procesarEfectivo" method="POST" style="display:none;"></form>
            </div>
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