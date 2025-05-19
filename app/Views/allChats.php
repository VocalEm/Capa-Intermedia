<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    require_once __DIR__ . '/plantillas/subnav.php';
    ?>
    <section class="chats-listado">
        <h2>Chats</h2>
        <ul class="lista-chats">
            <?php if (!empty($chats)): ?>
                <?php foreach ($chats as $chat): ?>
                    <a href="/chat/<?= $chat['chat_id'] ?>" class="chat-item" onclick="window.location.href='chat.php?id=<?= $chat['chat_id']; ?>'">
                        <img
                            src="/uploads/<?= !empty($chat['multimedia']) ? $chat['multimedia'][0] : 'src/img/default.jpg'; ?>"
                            alt="<?= htmlspecialchars($chat['producto_nombre']); ?>"
                            class="chat-miniatura" />
                        <div class="chat-info">
                            <p class="chat-usuario"><strong>
                                    <?php
                                    $usuarioExterno = ($chat['comprador_id'] == $_SESSION['usuario']['id']) ? $chat['vendedor_username'] : $chat['comprador_username'];
                                    echo htmlspecialchars($usuarioExterno);
                                    ?>
                                </strong></p>
                            <p class="chat-producto"><?= htmlspecialchars($chat['producto_nombre']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="chat-item">
                    <p>No hay chats disponibles.</p>
                </li>
            <?php endif; ?>
        </ul>
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