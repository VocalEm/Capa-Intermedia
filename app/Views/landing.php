<?php
require_once __DIR__ . '/plantillas/head.php';
?>

<body>


    <?php
    require_once __DIR__ . '/plantillas/nav.php';
    ?>

    <section class="hero-image-section">
        <img src="/assets/pexels-olly-3791614.jpg" alt="Hero Image" class="hero-image">

        <div class="hero-text">
            Todo desde la comodidad de tu casa, en un mismo lugar.
        </div>

        <!-- Buttons on top of the image -->
        <div class="hero-buttons">
            <a class="fancy-button" href="/inicio_sesion">Entrar</a>

        </div>

        <!-- Wave overlay at bottom of image -->
        <div class="wave-bottom">
            <svg viewBox="0 0 1440 150" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M0,96 C360,0 1080,160 1440,64 L1440,150 L0,150 Z"></path>
            </svg>
        </div>
    </section>

    <div class="banner-container">
        <div class="text-box">
            <div class="text-content">
                <h1>En BUYLY, encontrarás todo lo que necesitas, ¡y más! Ofrecemos una experiencia de compra única con productos de alta calidad en una variedad de categorías.
                </h1>
            </div>
        </div>
        <div class="image-box"></div>
    </div>



    <!-- Font Awesome for Icons -->
    <?php
    require_once __DIR__ . '/plantillas/footer.php';
    require_once __DIR__ . '/plantillas/scripts.php';
    ?>

    <script src="build/js/main.js"></script>
</body>

</html>