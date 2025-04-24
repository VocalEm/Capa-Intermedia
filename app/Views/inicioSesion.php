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
                    <input type="email" id="loginEmail" name="loginEmail" required>
                </div>

                <div class="form-group">
                    <label for="loginPassword">Contraseña</label>
                    <input type="password" id="loginPassword" name="loginPassword" required>
                </div>

                <input type="submit" class="btn-registrar" value="Iniciar Sesión">
            </form>

            <!-- Formulario de Registro -->
            <form id="registroForm" class="auth-form hidden" enctype="multipart/form-data" method="POST" action="/registro">
                <h2>Crear Cuenta</h2>

                <div class="form-group">
                    <label for="nombreCompleto">Nombre</label>
                    <input type="text" id="nombreCompleto" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="nombreCompleto">Apellido Paterno</label>
                    <input type="text" id="nombreCompleto" name="apellido_p" required>
                </div>

                <div class="form-group">
                    <label for="nombreCompleto">Apellido Materno</label>
                    <input type="text" id="nombreCompleto" name="apellido_m" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" minlength="3" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password"
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                        title="Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial."
                        required>
                </div>

                <div class="form-group">
                    <label for="rol">Rol de usuario</label>
                    <select id="rol" name="rol" required>
                        <option value="" disabled selected>Selecciona un rol</option>
                        <option value="comprador">Comprador</option>
                        <option value="vendedor">Vendedor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="privacidad">Privacidad de perfil</label>
                    <select id="privacidad" name="privacidad" disabled required>
                        <option value="" disabled selected>Selecciona privacidad</option>
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
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Selecciona</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>

                <input type="submit" class="btn-registrar" value="Registrarse">
            </form>

            <div id="mensajeRegistro"></div>
        </div>
    </section>

    <!-- Font Awesome for Icons -->
    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>
    <script src="/js/login.js"></script>

</body>

</html>
````