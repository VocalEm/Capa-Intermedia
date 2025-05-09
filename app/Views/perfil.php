<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>



    <section class="perfil-section">
        <div class="perfil-card">
            <div class="perfil-header">
                <img src="/uploads/<?= htmlspecialchars($usuario['IMAGEN']) ?>" alt="Foto de perfil" class="foto-perfil" />
                <div class="perfil-header-info">
                    <h2>@<?=
                            $usuario['USERNAME']
                            ?></h2>
                    <p><?= $usuario['NOMBRE'] . $usuario['APELLIDO_P'] . $usuario['APELLIDO_M'] ?></p>
                    <p><?= $usuario['CORREO'] ?></p>
                </div>

            </div>

            <div class="listas-usuario">
                <h3>Mis Listas</h3>
                <div id="listas-container" class="listas-container">
                    <?php if (!empty($listasConProductos)): ?>
                        <?php foreach ($listasConProductos as $lista): ?>
                            <div class="lista-card">
                                <!-- Botón de eliminar con SweetAlert -->
                                <button class="lista-card-botones" onclick="confirmarEliminacion(<?= $lista['ID']; ?>)">
                                    <i class="fa-solid fa-trash fa-2x"></i>
                                </button>
                                <div class="lista-card-img">
                                    <img src="/uploads/<?= $lista['IMAGEN'] ?>" alt="">
                                </div>
                                <h4 class="lista-card-titulo" style="font-size: 2rem; "><?= htmlspecialchars($lista['NOMBRE']) ?></h4>
                                <p class="descripcion" style="font-size:1.5rem;   font-weight: bold;"><?= htmlspecialchars($lista['DESCRIPCION']) ?></p>
                                <p class="visibilidad" style="font-size:1.5rem;   font-weight: bold;">
                                    Visibilidad: <?= $lista['PRIVACIDAD'] ? 'Pública' : 'Privada' ?>
                                </p>

                                <div class="productos-lista">
                                    <?php if (!empty($lista['productos'])): ?>
                                        <?php foreach ($lista['productos'] as $producto): ?>
                                            <div class="producto-card">
                                                <img src="/uploads/<?= htmlspecialchars($producto['IMAGEN']) ?>" alt="<?= htmlspecialchars($producto['NOMBRE']) ?>" />
                                                <h5><?= htmlspecialchars($producto['NOMBRE']) ?></h5>
                                                <p class="precio">$<?= number_format($producto['PRECIO'], 2) ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p style="font-size:1.5rem; color:red;   font-weight: bold;">No hay productos en esta lista.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tienes listas creadas.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="lista-tarjeta">
        <h2>Crear Lista</h2>
        <div id="crear" class="tab-content">
            <form class="form-crear-lista" action="/perfil/crear-lista" method="POST" enctype="multipart/form-data">
                <label>Nombre de la Lista:</label>
                <input name="nombre" type="text" placeholder="Ej. Lista de Compras" required />

                <label>Descripción:</label>
                <textarea style=" resize: vertical; overflow: auto; " name="descripcion" placeholder="Describe tu lista..."></textarea>

                <label>Imagen:</label>
                <input name="imagen" type="file" accept="image/*" required />

                <?php if ($usuario['PRIVACIDAD'] == 1): ?>
                    <label>Privacidad:</label>
                    <select name="privacidad" required>
                        <option value="publica">Pública</option>
                        <option value="privada">Privada</option>
                    </select>
                <?php else: ?>
                    <input type="hidden" name="privacidad" value="privada">
                <?php endif; ?>

                <button type="submit">Crear Lista</button>
            </form>
        </div>
    </div>


    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script>
        function confirmarEliminacion(idLista) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/perfil/eliminar-lista/${idLista}`;
                }
            });
        }
    </script>

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