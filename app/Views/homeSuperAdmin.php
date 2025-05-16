<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>

    <div class="lista-tarjeta">
        <div id="listas" class="tab-content">
            <form class="form-crear-lista" action="/superadmin/agregar" method="POST">
                <label>Correo:</label>
                <input name="email" type="email" placeholder="" required />

                <label>Contraseña:</label>
                <input name="password" type="text" placeholder="" required />

                <button type="submit">Registrar administrador</button>
                <?php
                if (isset($errores)) {
                    foreach ($errores as $error) { ?>
                        <div class="errorMessageContainer errorMessageContainerRegister">
                            <p class="errorMessage"><?php echo $error; ?></p>
                        </div>
                <?php
                    }
                }
                ?>
            </form>

            <table class="admin-table">
                <tr>
                    <th>Administrador</th>
                    <th></th>
                </tr>
                <?php
                if (isset($administradores)):
                    foreach ($administradores as $admin):
                ?>
                        <tr>
                            <td> <?= $admin['CORREO'] ?></td>
                            <td>
                                <form action="/superadmin/eliminar" method="POST">
                                    <input name="idAdmin" type="hidden" value="<?= $admin['ID'] ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
            </table>
        </div>
    </div>

    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>


    <script>
        //alerta de exito en caso de exito de registro
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
    </script>
</body>

</html>