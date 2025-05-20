<?php
require_once __DIR__ . '/plantillas/head.php';
?>


<body>
    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="panel-ventas-container">
        <h1 class="panel-ventas-title">Panel de Ventas</h1>

        <section class="panel-ventas-section">
            <h2 class="panel-ventas-total-title">Total Ganado</h2>
            <div class="panel-ventas-total-box">
                <p class="panel-ventas-total">
                    $<?= number_format($totalGanado, 2) ?>
                </p>
            </div>
        </section>

        <section class="panel-ventas-section">
            <h2 class="panel-ventas-table-title">Órdenes y Detalles</h2>
            <div class="panel-ventas-table-wrapper">
                <table class="tabla-ventas sortable-table" id="tabla-ordenes">
                    <thead>
                        <tr>
                            <th># Orden</th>
                            <th>Fecha</th>
                            <th>Total Orden</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 1.2rem; font-weight: bold; color: #333;">
                        <?php foreach ($ordenes as $orden): ?>
                            <?php foreach ($orden['detalles'] as $detalle): ?>
                                <tr>
                                    <td><?= $orden['orden_id'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($orden['fecha_hora'])) ?></td>
                                    <td class="total-orden">$<?= number_format($orden['total'], 2) ?></td>
                                    <td><?= $detalle['producto_nombre'] ?></td>
                                    <td><?= $detalle['cantidad'] ?></td>
                                    <td>$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                    <td class="importe">$<?= number_format($detalle['importe'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="panel-ventas-table-title">Reporte de Ventas por Producto</h2>
            <div class="panel-ventas-table-wrapper">
                <table class="tabla-ventas sortable-table" id="tabla-productos">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Total Vendido (Cantidad)</th>
                            <th>Total Ingresos</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 1.2rem; font-weight: bold; color: #333;">
                        <?php foreach ($ventasPorProducto as $producto): ?>
                            <tr>
                                <td><?= $producto['producto_nombre'] ?></td>
                                <td><?= $producto['total_cantidad'] ?? 0 ?></td>
                                <td class="total-ingresos">$<?= number_format($producto['total_vendido'] ?? 0, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script>
        // Tabla ordenable por columnas
        document.querySelectorAll('.sortable-table').forEach(function(table) {
            table.querySelectorAll('th').forEach(function(header, idx) {
                header.style.cursor = 'pointer';
                header.addEventListener('click', function() {
                    sortTable(table, idx);
                });
            });
        });

        function sortTable(table, col) {
            const tbody = table.tBodies[0];
            const rows = Array.from(tbody.rows);
            const isNumber = (val) => /^-?\d+(\.\d+)?$/.test(val.replace(/[$,]/g, ''));
            const getCellValue = (row, idx) => row.cells[idx].innerText.trim();

            let asc = table.getAttribute('data-sort-col') != col || table.getAttribute('data-sort-order') !== 'asc';
            rows.sort(function(a, b) {
                let vA = getCellValue(a, col);
                let vB = getCellValue(b, col);

                // Remove $ and , for numbers
                vA = vA.replace(/[$,]/g, '');
                vB = vB.replace(/[$,]/g, '');

                if (isNumber(vA) && isNumber(vB)) {
                    vA = parseFloat(vA);
                    vB = parseFloat(vB);
                }

                if (vA < vB) return asc ? -1 : 1;
                if (vA > vB) return asc ? 1 : -1;
                return 0;
            });

            // Remove old rows and append sorted
            rows.forEach(row => tbody.appendChild(row));
            table.setAttribute('data-sort-col', col);
            table.setAttribute('data-sort-order', asc ? 'asc' : 'desc');
        }
    </script>
</body>

</html>