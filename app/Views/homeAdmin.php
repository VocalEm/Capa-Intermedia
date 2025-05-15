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
        <h2>Productos Pendientes de Aprobar</h2>

        <?php if (empty($productos)): ?>
            <p>No hay productos pendientes de aprobación.</p>
        <?php else: ?>
            <div class="productos-grid">
                <?php foreach ($productos as $producto): ?>
                    <div class="producto-tarjeta">
                        <img
                            src="<?= !empty($producto['multimedia']) ? $producto['multimedia'][0] : '/path/to/default/image.jpg' ?>"
                            alt="<?= htmlspecialchars($producto['producto']['NOMBRE']) ?>"
                            class="producto-imagen" />

                        <div class="producto-info">
                            <p class="producto-nombre">
                                <strong><?= htmlspecialchars($producto['NOMBRE']) ?></strong>
                            </p>
                            <p class="producto-descripcion">
                                <?= htmlspecialchars($producto['DESCRIPCION']) ?>
                            </p>

                            <div class="acciones">
                                <form action="/producto/aprobar" method="POST">
                                    <input type="hidden" name="producto_id" value="<?= $producto['ID'] ?>">
                                    <button type="submit" class="btn-aprobar">Aprobar</button>
                                </form>

                                <form action="/producto/rechazar" method="POST">
                                    <input type="hidden" name="producto_id" value="<?= $producto['ID'] ?>">
                                    <button type="submit" class="btn-rechazar">Rechazar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>


    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script src="/js/home.js"></script>
</body>

</html>