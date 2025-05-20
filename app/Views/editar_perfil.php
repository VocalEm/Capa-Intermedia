<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    ?>

    <section class="registro-container">
        <div class="registro-card">

            <!-- Formulario de Registro -->
            <form id="registroForm" class="auth-form" enctype="multipart/form-data" method="POST" action="/perfil/editar">
                <h2>Editar Perfil</h2>

                <div class="form-group">
                    <label for="nombreCompleto">Nombre</label>
                    <input type="text" id="nombreCompleto" name="NOMBRE" value="<?= htmlspecialchars($usuario['NOMBRE'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" id="apellidoPaterno" name="APELLIDO_P" value="<?= htmlspecialchars($usuario['APELLIDO_P'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" id="apellidoMaterno" name="APELLIDO_M" value="<?= htmlspecialchars($usuario['APELLIDO_M'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="CORREO" value="<?= htmlspecialchars($usuario['CORREO'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="USERNAME" value="<?= htmlspecialchars($usuario['USERNAME'] ?? '') ?>" minlength="3" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="PASSW">
                </div>

                <div class="form-group">
                    <label for="privacidad">Privacidad de perfil</label>
                    <select id="privacidad" name="PRIVACIDAD" required <?= (isset($usuario['ROL']) && $usuario['ROL'] === 'vendedor') ? 'disabled' : '' ?>>
                        <option selected disabled>Selecciona privacidad</option>
                        <option value="1" <?= ($usuario['PRIVACIDAD'] ?? '') === '1' ? 'selected' : '' ?>>Público</option>
                        <option value="0" <?= ($usuario['PRIVACIDAD'] ?? '') === '0' ? 'selected' : '' ?>>Privado</option>
                    </select>
                    <?php if (isset($usuario['ROL']) && $usuario['ROL'] === 'vendedor'): ?>
                        <input type="hidden" name="PRIVACIDAD" value="<?= htmlspecialchars($usuario['PRIVACIDAD'] ?? '1') ?>">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="avatar">Imagen de avatar</label>
                    <input type="file" id="avatar" name="IMAGEN" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="SEXO" required>
                        <option value="" <?= empty($usuario['SEXO']) ? 'selected' : '' ?>>Selecciona</option>
                        <option value="M" <?= ($usuario['SEXO'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= ($usuario['SEXO'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                    </select>
                </div>

                <input type="submit" class="btn-registrar" value="Guardar cambios">
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





</body>

</html>