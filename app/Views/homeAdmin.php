<?php

use App\Middlewares\AuthMiddleware;

require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="productos-pendientes">
        <h2>Productos Pendientes de Aprobación</h2>
        <div class="productos-grid" id="productos-grid"></div>
    </section>


    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>


    </script>


</body>

</html>