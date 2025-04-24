<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <img src="/assets/Buyly.png" alt="Logo" class="logo">
        </div>
        <div class="navbar-underline"></div>
    </nav>

    <section class="registro-container">
        <div class="registro-card">
            <div class="tab-buttons">
                <button id="btnLogin" class="tab active">Iniciar Sesión</button>
                <button id="btnRegistro" class="tab">Registrarse</button>
            </div>

            <!-- Formulario de Login -->
            <form id="loginForm" class="auth-form">
                <h2>Iniciar Sesión</h2>
                <div class="form-group">
                    <label for="loginEmail">Correo electrónico</label>
                    <input type="email" id="loginEmail" name="loginEmail" required>
                </div>

                <div class="form-group">
                    <label for="loginPassword">Contraseña</label>
                    <input type="password" id="loginPassword" name="loginPassword" required>
                </div>

                <button type="submit" class="btn-registrar">Entrar</button>
            </form>

            <!-- Formulario de Registro -->
            <form id="registroForm" class="auth-form hidden" enctype="multipart/form-data">
                <h2>Crear Cuenta</h2>

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
                        <option value="">Selecciona un rol</option>
                        <option value="cliente">Cliente</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="privacidad">Privacidad de perfil</label>
                    <select id="privacidad" name="privacidad" required>
                        <option value="">Selecciona privacidad</option>
                        <option value="publico">Público</option>
                        <option value="privado">Privado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="avatar">Imagen de avatar</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="nombreCompleto">Nombre completo</label>
                    <input type="text" id="nombreCompleto" name="nombreCompleto" required>
                </div>

                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Selecciona</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <button type="submit" class="btn-registrar">Registrarse</button>
            </form>

            <div id="mensajeRegistro"></div>
        </div>
    </section>


    <footer class="footer">
        <div class="footer-content">
            <!-- Left side: Logo -->
            <img src="/assets/Buyly.png" alt="BUYLY Logo" class="footer-logo">

            <!-- Center: All rights reserved text -->
            <p class="footer-text">© 2025 BUYLY. Todos los derechos reservados.</p>

            <!-- Right side: Social media icons -->
            <div class="social-icons">
                <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            </div>
        </div>
    </footer>

    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>
    <script src="/js/login.js"></script>

</body>

</html>