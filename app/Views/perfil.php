<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <?php
    if ($usuario['ROL'] == 'vendedor'): //perfil si es vendedor
    ?>
        <section class="vendedor-isla">
            <div class="vendedor-card">
                <div class="vendedor-header">
                    <img src="/uploads/<?= htmlspecialchars($usuario['IMAGEN']) ?>" alt="Foto de perfil" class="vendedor-foto" />
                    <h2>@<?= $usuario['USERNAME'] ?></h2>
                    <p><?= $usuario['NOMBRE'] . ' ' . $usuario['APELLIDO_P'] . ' ' . $usuario['APELLIDO_M'] ?></p>
                    <p><?= $usuario['CORREO'] ?></p>
                </div>

                <div class="vendedor-productos" id="vendedor-productos">
                    <?php
                    foreach ($productos as $producto):
                    ?>
                        <a href="/producto/eliminar/<?= $producto['ID'] ?>" class="vendedor-botones">
                            <i class="fa-solid fa-trash fa-2x"></i>
                        </a>
                        <a href="/producto/editar/<?= $producto['ID'] ?>" class="vendedor-producto">
                            <img src="/uploads/<?= $producto['multimedia'][0] ?>" alt="">
                            <div class="vendedor-info">
                                <h4> <?= $producto['NOMBRE'] ?> </h4>
                                <p><?= $producto['DESCRIPCION'] ?></p>
                                <p class="precio">
                                    <?= $producto['PRECIO'] ?? 'Cotizacion' ?>
                                </p>
                            </div>
                        </a>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </section>

    <?php
    elseif ($usuario['ROL'] == 'comprador'): //perfil si es comprador
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

                <?php
                if ($usuario['PRIVACIDAD'] || $miPerfil): //si es publico muestra las listas o si es mi perfil
                ?>
                    <div class="listas-usuario">
                        <h3>Listas</h3>
                        <div id="listas-container" class="listas-container">
                            <?php if (!empty($listas)): ?>
                                <?php foreach ($listas as $lista):
                                    if ($miPerfil == false): //si no es mi perfil
                                        if ($lista['PRIVACIDAD']):  // y la lista es publica
                                ?>
                                            <a href="/lista/<?= $lista['ID'] ?>" class="lista-card">
                                                <div class="lista-card-img">
                                                    <img src="/uploads/<?= $lista['IMAGEN'] ?>" alt="">
                                                </div>
                                                <h4 class="lista-card-titulo" style="font-size: 2rem; "><?= htmlspecialchars($lista['NOMBRE']) ?></h4>
                                                <p class="descripcion" style="font-size:1.5rem;   font-weight: bold;"><?= htmlspecialchars($lista['DESCRIPCION']) ?></p>
                                                <p class="visibilidad" style="font-size:1.5rem;   font-weight: bold;">
                                                    Visibilidad: <?= $lista['PRIVACIDAD'] ? 'Pública' : 'Privada' ?>
                                                </p>

                                            </a>
                                        <?php
                                        endif;
                                    else: ?>
                                        <a href="/lista/<?= $lista['ID'] ?>" class="lista-card">
                                            <!-- Botón de eliminar con SweetAlert -->
                                            <?php
                                            if ($miPerfil && isset($miPerfil)):
                                            ?>
                                                <button class="lista-card-botones" onclick="confirmarEliminacion(<?= $lista['ID']; ?>)">
                                                    <i class="fa-solid fa-trash fa-2x"></i>
                                                </button>
                                            <?php
                                            endif;
                                            ?>
                                            <div class="lista-card-img">
                                                <img src="/uploads/<?= $lista['IMAGEN'] ?>" alt="">
                                            </div>
                                            <h4 class="lista-card-titulo" style="font-size: 2rem; "><?= htmlspecialchars($lista['NOMBRE']) ?></h4>
                                            <p class="descripcion" style="font-size:1.5rem;   font-weight: bold;"><?= htmlspecialchars($lista['DESCRIPCION']) ?></p>
                                            <p class="visibilidad" style="font-size:1.5rem;   font-weight: bold;">
                                                Visibilidad: <?= $lista['PRIVACIDAD'] ? 'Pública' : 'Privada' ?>
                                            </p>

                                        </a>
                                <?php
                                    endif;
                                endforeach; ?>
                            <?php else: ?>
                                <p>No tienes listas creadas.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                else: ?>
                    <p>Este perfil es privado</p>
                <?php endif;
                ?>

            </div>
        </section>

        <?php // crear lista
        if ($miPerfil):
        ?>
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
                        <label>Privacidad:</label>
                        <select name="privacidad" required>
                            <option value="publica">Pública</option>
                            <option value="privada">Privada</option>
                        </select>
                        <button type="submit">Crear Lista</button>
                    </form>
                </div>
            </div>
        <?php
        endif;
    elseif ($usuario['ROL'] == 'administrador'): //perfil si es admin
        ?>
        <div class="product-tabs">
            <div class="tabs">
                <button class="tab active" onclick="showTab('aprobados')">
                    Productos Aprobados
                </button>
                <button class="tab" onclick="showTab('denegados')">
                    Productos Denegados
                </button>
            </div>

            <div class="tab-content" id="aprobados">
                <div class="product-card-list" id="aprobados-list">
                    <!-- Tarjetas se insertarán aquí -->
                    <?php

                    foreach ($autorizados as $autorizado):

                    ?>
                        <div class="product-card">
                            <h3><?= $autorizado['NOMBRE'] ?></h3>
                            <p><strong>Vendedor:</strong> <?= $autorizado['vendedor_correo'] ?></p>
                            <p class="price"><strong>Precio:</strong> <?= $autorizado['TIPO_PUBLICACION'] == 'venta' ? '$' . $autorizado['PRECIO'] : 'Cotizacion' ?></p>
                            <p><strong>Descripción:</strong> <?= $autorizado['DESCRIPCION'] ?></p>
                            <p class="date"><strong>Fecha:</strong> <?= $autorizado['FECHA_CREACION'] ?></p>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="tab-content hidden" id="denegados">
                <div class="product-card-list" id="denegados-list">
                    <!-- Tarjetas se insertarán aquí -->
                    <?php
                    foreach ($rechazados as $rechazado):
                    ?>
                        <div class="product-card">
                            <h3><?= $rechazado['NOMBRE'] ?></h3>
                            <p><strong>Vendedor:</strong> <?= $rechazado['vendedor_correo'] ?></p>
                            <p class="price"><strong>Precio:</strong> <?= $rechazado['TIPO_PUBLICACION'] == 'venta' ? '$' . $rechazado['PRECIO'] : 'Cotizacion' ?></p>
                            <p><strong>Descripción:</strong> <?= $rechazado['DESCRIPCION'] ?></p>
                            <p class="date"><strong>Fecha:</strong> <?= $rechazado['FECHA_CREACION'] ?></p>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>


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

    <script src="/js/adminaprobados.js"></script>

</body>

</html>