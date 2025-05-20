<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>


    <?php
    if ($chat['ESTADO'] == 'cerrado') {
    ?>

        <div style="width:100%; background-color: red; color:white; text-align:center; margin: 0; padding: 0;">
            <h2 style="font-size: 2rem; color:white;">CERRADO</h2>
        </div>
    <?php
    }
    ?>


    <?php
    if ($_SESSION['usuario']['rol'] == 'vendedor') {
    ?>
        <div class="chat-cotizar" <?php
                                    if ($chat['ESTADO'] == 'cerrado') {
                                        echo 'style="display:block;"';
                                    }
                                    ?>>
            <?php
            if ($chat['ESTADO'] !== 'cerrado'):
            ?>
                <form action="/chat/crearOferta" method="POST" class=" isla-chat formulario-cotizar">
                    <label class="cotizar-label" for="Precio:">Coloca precio acordado:</label>

                    <div class="chat-input cotizar-input">
                        <input
                            name="precio"
                            type="number"
                            id="ofertaInput"
                            placeholder="Ingresa tu Precio" />
                        <input type="hidden" name="idChat" value="<?= $chat['ID'] ?>" />
                    </div>
                    <button type="submit" class="boton-cotizar">Lanzar Oferta</button>
                </form>
            <?php
            endif;
            ?>

            <div class="isla-chat">
                <a href="/chat" class="btn-regresar">
                    <i class="fa fa-arrow-left"></i> Regresar
                </a>

                <div class="info-cotizacion">
                    <img
                        src="/uploads/<?= $chat['multimedia'][0] ?>"
                        alt="Miniatura del producto"
                        class="producto-miniatura" />
                    <div class="info-datos">
                        <label><strong>Usuario:</strong> <?= $usuarioExterno ?></label>
                        <label><strong>Producto a cotizar:</strong> <?= $chat['producto_nombre'] ?></label>
                    </div>
                </div>

                <h2>Chat Privado</h2>
                <label id="usuarioInput"><?= $usuarioExterno ?></label>

                <div class="chat-box">
                    <div class="chat-mensajes" id="chatMensajes">
                        <!-- Mensajes irán aquí -->

                    </div>
                    <?php
                    if ($chat['ESTADO'] !== 'cerrado'):
                    ?>
                        <form action="/chat/enviarMensaje" method="POST" class="chat-input">
                            <input required
                                name="mensaje"
                                type="text"
                                id="mensajeInput"
                                placeholder="Escribe un mensaje..." />
                            <input type="hidden" name="idChat" value="<?= $chat['ID'] ?>" />
                            <button type="submit" id="enviarBtn"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    <?php
                    endif;
                    ?>
                </div>
            </div>


        </div>
    <?php
    } else {
    ?>
        <div class="chat-cotizar" <?php
                                    if ($chat['ESTADO'] == 'cerrado') {
                                        echo 'style="display:block;"';
                                    }
                                    ?>>
            <?php
            if ($chat['ESTADO'] !== 'cerrado'):
            ?>
                <form class=" isla-chat formulario-cotizar" id="formulario-oferta-comprador" method="POST" action="/chat/aceptarOferta">
                    <label class="cotizar-label" for="Precio:">Precio acordado:</label>

                    <h2 id="precio-oferta-comprador"> </h2>

                </form>
            <?php
            endif;
            ?>

            <div class="isla-chat">
                <a href='/chat' class="btn-regresar">
                    <i class="fa fa-arrow-left"></i> Regresar
                </a>

                <div class="info-cotizacion">
                    <img
                        src="/uploads/<?= $chat['multimedia'][0] ?>"
                        alt="Miniatura del producto"
                        class="producto-miniatura" />
                    <div class="info-datos">
                        <label><strong>Usuario:</strong> <?= $usuarioExterno ?></label>
                        <label><strong>Producto a cotizar:</strong> <?= $chat['producto_nombre'] ?></label>
                    </div>
                </div>

                <h2>Chat Privado</h2>
                <label id="usuarioInput"><?= $usuarioExterno ?></label>

                <div class="chat-box">
                    <div class="chat-mensajes" id="chatMensajes">
                        <!-- Mensajes irán aquí -->
                    </div>
                    <?php
                    if ($chat['ESTADO'] !== 'cerrado'):
                    ?>
                        <form action="/chat/enviarMensaje" method="POST" class="chat-input">
                            <input required
                                name="mensaje"
                                type="text"
                                id="mensajeInput"
                                placeholder="Escribe un mensaje..." />
                            <input type="hidden" name="idChat" value="<?= $chat['ID'] ?>" />
                            <button type="submit" id="enviarBtn"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    <?php
                    endif;
                    ?>
                </div>
            </div>


        </div>
    <?php
    }
    ?>


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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatMensajes = document.getElementById('chatMensajes');
            const precioOfertaComprador = document.getElementById('precio-oferta-comprador');
            const inputPrecio = document.getElementById('ofertaInput');
            const botonOferta = document.querySelector('.formulario-cotizar .boton-cotizar');
            const formularioOfertaComprador = document.getElementById('formulario-oferta-comprador');

            // Función para obtener productos pendientes
            function obtenerMensajesPendientes() {
                fetch('/chat/mensajesOferta/<?= $chat['ID'] ?>', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Mostrar la respuesta completa en consola para depuración

                        chatMensajes.innerHTML = ''; // Limpiamos el contenedor de mensajes

                        // Iteramos sobre los mensajes y los agregamos al contenedor
                        if (data.status === 'success' && data.mensajes.length > 0) {
                            data.mensajes.forEach(mensaje => {
                                const mensajeP = document.createElement('p');
                                mensajeP.classList.add('mensaje');
                                mensajeP.innerHTML = `<strong>${mensaje.USERNAME}:</strong> ${mensaje.MENSAJE}`;
                                chatMensajes.appendChild(mensajeP);
                            });
                        } else {
                            chatMensajes.innerHTML = '<p>No hay mensajes disponibles.</p>';
                        }

                        // Verificar si hay una oferta
                        if (data.status === 'success' && data.oferta) {

                            // Si existe `precioOfertaComprador`, estamos en la vista del comprador
                            if (precioOfertaComprador) {
                                precioOfertaComprador.innerHTML = `<strong>Oferta:$</strong> ${data.oferta.PRECIO_ACORDADO}`;
                            }

                            // Deshabilitar input y botón en la vista del vendedor
                            if (inputPrecio && botonOferta) {
                                inputPrecio.disabled = true;
                                botonOferta.disabled = true;
                            }
                            // Verificar si el botón "rechazar-oferta" ya existe
                            let botonAceptar = formularioOfertaComprador.querySelector('.aceptar-oferta');

                            if (!botonAceptar) {
                                // Crear el botón solo si no existe
                                botonAceptar = document.createElement('button');
                                botonAceptar.classList.add('aceptar-oferta', 'boton-cotizar');
                                botonAceptar.textContent = 'Aceptar Oferta';
                                botonAceptar.onclick = function(e) {
                                    e.preventDefault();

                                    // Verificamos que el formulario exista
                                    if (formularioOfertaComprador) {
                                        // Agregar un input oculto para enviar el ID del chat
                                        let inputIdChat = formularioOfertaComprador.querySelector('input[name="idChat"]');

                                        if (!inputIdChat) {
                                            inputIdChat = document.createElement('input');
                                            inputIdChat.type = 'hidden';
                                            inputIdChat.name = 'idChat';
                                            formularioOfertaComprador.appendChild(inputIdChat);
                                        }

                                        let inputOferta = formularioOfertaComprador.querySelector('input[name="precio"]');

                                        if (!inputOferta) {
                                            inputOferta = document.createElement('input');
                                            inputOferta.type = 'hidden';
                                            inputOferta.name = 'precio';
                                            formularioOfertaComprador.appendChild(inputOferta);
                                        }


                                        let inputIdProducto = formularioOfertaComprador.querySelector('input[name="idProducto"]');

                                        if (!inputIdProducto) {
                                            inputIdProducto = document.createElement('input');
                                            inputIdProducto.type = 'hidden';
                                            inputIdProducto.name = 'idProducto';
                                            formularioOfertaComprador.appendChild(inputIdProducto);
                                        }


                                        // Asignar el valor del ID del chat
                                        inputIdChat.value = data.oferta.ID_CHAT;
                                        inputIdProducto.value = <?= $chat['ID_PRODUCTO'] ?>;
                                        inputOferta.value = data.oferta.PRECIO_ACORDADO;
                                        // Cambiar la acción del formulario
                                        formularioOfertaComprador.action = '/chat/aceptarOferta';

                                        // Realizar el submit
                                        formularioOfertaComprador.method = 'POST';
                                        formularioOfertaComprador.submit();
                                    }
                                };
                                formularioOfertaComprador.appendChild(botonAceptar);
                            }

                            // Verificar si el botón "rechazar-oferta" ya existe
                            let botonRechazar = formularioOfertaComprador.querySelector('.rechazar-oferta');

                            if (!botonRechazar) {
                                // Crear el botón solo si no existe
                                botonRechazar = document.createElement('button');
                                botonRechazar.classList.add('rechazar-oferta', 'boton-cotizar');
                                botonRechazar.textContent = 'Rechazar Oferta';
                                botonRechazar.onclick = function(e) {
                                    e.preventDefault();
                                    window.location.href = '/chat/rechazarOferta/' + data.oferta.ID_CHAT;
                                };
                                formularioOfertaComprador.appendChild(botonRechazar);
                            }

                        } else {
                            // No hay oferta, habilitamos los elementos en la vista del vendedor
                            if (inputPrecio && botonOferta) {
                                inputPrecio.disabled = false;
                                botonOferta.disabled = false;
                            }

                            // Si existe `precioOfertaComprador`, limpiamos su contenido
                            if (precioOfertaComprador) {
                                precioOfertaComprador.innerHTML = '<p>No hay ofertas disponibles.</p>';
                            }

                            // Si existe el botón "rechazar-oferta", lo eliminamos
                            const botonRechazar = formularioOfertaComprador.querySelector('.rechazar-oferta');
                            if (botonRechazar) {
                                botonRechazar.remove();
                            }
                        }

                    })
                    .catch(error => {
                        console.error('Error al obtener los productos pendientes:', error);
                    });
            }

            // Llamamos a la función al cargar la página
            obtenerMensajesPendientes();

            // Establecemos un intervalo para actualizar la vista cada 5 segundos
            setInterval(obtenerMensajesPendientes, 2000);
        });
    </script>
</body>

</html>