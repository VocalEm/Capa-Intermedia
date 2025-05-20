<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>

    <?php

    ?>
    <section class="vendedor-isla">
        <div class="vendedor-card">
            <h2>Valora los productos</h2>

            <form action="/valoracion/valorarProductos" method="POST" class="vendedor-productos" id="vendedor-productos">
                <?php foreach ($productos as $producto): ?>
                    <div class="vendedor-producto" style="margin-bottom: 20px; flex-direction: column;">
                        <img src="/uploads/<?= $producto['multimedia'][0] ?>" alt="" style="width: 100px; height: 100px; object-fit: cover;">

                        <div class="vendedor-info">
                            <h4 style="font-size: 1.3rem;"> <?= $producto['NOMBRE'] ?> </h4>
                            <p style="font-size: 1.3rem;"><?= $producto['DESCRIPCION'] ?></p>
                            <p style="font-size: 1.3rem;" class="precio">
                                <?= $producto['PRECIO'] == 0 ? 'Cotización' : '$' . $producto['PRECIO'] ?>
                            </p>
                        </div>

                        <div class="valoracion-section">
                            <label for="rating-<?= $producto['ID'] ?>">Tu calificación:</label>
                            <select id="rating-<?= $producto['ID'] ?>" name="ratings[<?= $producto['ID'] ?>][puntuacion]" required>
                                <option value="">Selecciona una opción</option>
                                <option value="1">★☆☆☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="4">★★★★☆</option>
                                <option value="5">★★★★★</option>
                            </select>

                        </div>
                        <label for="comentario-<?= $producto['ID'] ?>">Comentario:</label>
                        <textarea required id="comentario-<?= $producto['ID'] ?>" name="ratings[<?= $producto['ID'] ?>][comentario]" rows="2" placeholder="Escribe un comentario..."></textarea>

                    </div>

                <?php endforeach; ?>

                <button class="boton-valoracion" type="submit">Enviar Valoraciones</button>
            </form>
        </div>
    </section>


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