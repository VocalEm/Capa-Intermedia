<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="product-tabs">



        <div class="tab-content" id="aprobados">
            <div class="product-card-list" id="aprobados-list">
                <!-- Tarjetas se insertarán aquí -->
                <?php

                foreach ($categorias as $categoria):

                ?>
                    <div class="product-card">
                        <h3 style="font-weight: bold; font-size:2rem;"><?= $categoria['TITULO'] ?></h3>
                        <p style="font-size: 1.4rem; font-weight:bold;"><strong style="font-size: 1.5rem; color: black;">Vendedor:</strong> <?= $categoria['USERNAME'] ?></p>
                        <p style="font-size: 1.2rem; font-weight:bold;"><strong style="font-size: 1.5rem; color: black;">Descripción:</strong> <?= $categoria['DESCRIPCION'] ?></p>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>


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