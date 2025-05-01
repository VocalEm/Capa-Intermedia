<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    ?>

    <section class="registro-container">
        <div class="registro-card">
            <div class="tab-buttons">
                <button id="btnLogin" class="tab active">Iniciar Sesión</button>
                <button id="btnRegistro" class="tab">Registrarse</button>
            </div>

            <!-- Formulario de Login -->
            <form id="loginForm" class="auth-form" method="POST" action="/login" enctype="multipart/form-data">
                <h2>Iniciar Sesión</h2>
                <div class="form-group">
                    <label for="loginEmail">Correo electrónico</label>
                    <input type="text" id="loginEmail" name="loginEmail" required>
                </div>

                <div class="form-group">
                    <label for="loginPassword">Contraseña</label>
                    <input type="password" id="loginPassword" name="loginPassword" required>
                </div>

                <input type="submit" class="btn-registrar" value="Iniciar Sesión">

                <?php
                if (isset($erroresLogin)) {
                ?>
                    <div id='errorMessageContainerLogin' class="errorMessageContainer">
                        <p class="errorMessage"><?php echo $erroresLogin; ?></p>
                    </div>
                <?php
                }
                ?>
            </form>

            <!-- Formulario de Registro -->
            <form id="registroForm" class="auth-form <?= isset($errores) && $errores ? '' : 'hidden' ?>" enctype="multipart/form-data" method="POST" action="/registro">
                <h2>Crear Cuenta</h2>



                <div class="form-group">
                    <label for="nombreCompleto">Nombre</label>
                    <input type="text" id="nombreCompleto" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" id="apellidoPaterno" name="apellido_p" value="<?= htmlspecialchars($_POST['apellido_p'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" id="apellidoMaterno" name="apellido_m" value="<?= htmlspecialchars($_POST['apellido_m'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" minlength="3" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="rol">Rol de usuario</label>
                    <select id="rol" name="rol" required>
                        <option value="" selected disabled>Selecciona un rol</option>
                        <option value="comprador">Comprador</option>
                        <option value="vendedor">Vendedor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="privacidad">Privacidad de perfil</label>
                    <select id="privacidad" name="privacidad" required>
                        <option value="" selected disabled>Selecciona privacidad</option>
                        <option value="1">Público</option>
                        <option value="0">Privado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="avatar">Imagen de avatar</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?= htmlspecialchars($_POST['fechaNacimiento'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="" <?= empty($_POST['sexo']) ? 'selected' : '' ?>>Selecciona</option>
                        <option value="M" <?= ($_POST['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= ($_POST['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                    </select>
                </div>

                <input type="submit" class="btn-registrar" value="Registrarse">
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



        </div>
    </section>

    <!-- Font Awesome for Icons -->
    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <?php
    // Define las variables en PHP
    $mostrarLogin = $erroresLogin ?? false;
    $mostrarRegistro = isset($error) || isset($errorCorreo) || isset($errorUsername);

    ?>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php if ($mostrarLogin): ?>
                document.getElementById('btnLogin').click();

            <?php elseif ($mostrarRegistro): ?>
                document.getElementById('btnRegistro').click();
            <?php endif; ?>
        });

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
    <script src="/js/login.js"></script>


</body>

</html>