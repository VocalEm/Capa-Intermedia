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
            <h2>Buscar Usuarios y Vendedores</h2>
            <form class="busqueda-barra" action="/buscar/usuarios" method="GET">
                <input type="text" id="inputBusqueda" name="username" placeholder="Buscar por nombre o usuario...">
                <button type="submit" onclick="buscarContenido()"><i class="fa fa-search"></i></button>
            </form>

            <div id="resultados" class="resultados-busqueda">
                <?php
                if (isset($usuarios)):
                    foreach ($usuarios as $usuario):
                ?>
                        <a href="/perfil/<?= $usuario['ID'] ?>" class="resultado-card">
                            <img src="/uploads/<?= $usuario['IMAGEN'] ?>" alt="<?= $usuario['NOMBRE'] ?>">
                            <h3><?= $usuario['NOMBRE'] ?></h3>
                            <p style="font-size: 1rem; font-weight:bold;">Usuario: <?= $usuario['USERNAME'] ?></p>

                        </a>
                    <?php
                    endforeach;
                else:
                    ?>
                    <p style="font-weight: bold; font-size:2rem;">No se encontraron resultados para la búsqueda.</p>
                <?php
                endif;
                ?>
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