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
            <h2>Pagar con PayPal</h2>
            <div id="paypal-button-container"></div>
        </div>
    </section>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script src="https://www.paypal.com/sdk/js?client-id=AYzM-qBANn-OC_AapcCo2g_jqCPhg23oL4rSbqYGxyPjFAsogsFRGiYiDXGGIxQ16EI2K8djGXATW_pd&currency=MXN"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $total ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Redirige a tu backend para procesar la orden
                    window.location.href = "/pago/procesarPaypal?paypal_order_id=" + data.orderID;
                });
            }
        }).render('#paypal-button-container');
    </script>

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