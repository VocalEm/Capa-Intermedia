<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>
    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <section class="compras-reporte-container">
        <h2 class="compras-reporte-title">Mis Compras</h2>
        <div class="compras-reporte-table-wrapper">
            <table class="compras-reporte-table">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody style="font-size: 1.2rem; font-weight:bold;">
                    <?php if (!empty($compras)): ?>
                        <?php foreach ($compras as $orden): ?>
                            <tr>
                                <td>#<?= htmlspecialchars($orden['orden_id']) ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d', strtotime($orden['fecha_hora']))) ?></td>
                                <td>$<?= number_format($orden['total'], 2) ?></td>
                                <td>
                                    <button class="compras-reporte-toggle" onclick="toggleDetalle('detalle-<?= $orden['orden_id'] ?>')">Ver detalle</button>
                                </td>
                            </tr>
                            <tr id="detalle-<?= $orden['orden_id'] ?>" class="compras-reporte-detalle-row" style="display:none;">
                                <td colspan="4">
                                    <div class="compras-reporte-detalle">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orden['detalles'] as $detalle): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($detalle['producto_nombre']) ?></td>
                                                        <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                                                        <td>$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                                        <td>$<?= number_format($detalle['importe'], 2) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No tienes compras registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        function toggleDetalle(id) {
            var row = document.getElementById(id);
            if (row.style.display === "none") {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    </script>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>
</body>

</html>