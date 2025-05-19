<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <section class="busqueda-section">
        <div class="busqueda-card">
            <h2>Buscar productos o usuarios</h2>
            <div class="busqueda-barra">
                <input type="text" id="inputBusqueda" placeholder="Buscar por nombre o usuario...">
                <select id="filtro">
                    <option value="">Ordenar por...</option>
                    <option value="precioAsc">Menor precio</option>
                    <option value="precioDesc">Mayor precio</option>
                    <option value="rating">Mejor calificados</option>
                    <option value="ventas">Más vendidos</option>
                </select>
                <button onclick="buscarContenido()"><i class="fa fa-search"></i></button>
            </div>

            <div id="resultados" class="resultados-busqueda">
                <div class="resultado-card">
                    <img src="${p.imagen}" alt="${p.nombre}">
                    <h3>${p.nombre}</h3>
                    <p>Vendedor: ${p.usuario}</p>
                    <p>Rating: ⭐ ${p.rating}</p>
                    <p class="precio">$${p.precio}</p>
                </div>
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