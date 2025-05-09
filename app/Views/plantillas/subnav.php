<div class="sub-bar">
    <div class="sub-bar-links">
        <?php
        if ($_SESSION['usuario']['rol'] == 'comprador') {
        ?>
            <a href="/catalogo">Catalogo</a>
            <a href="#">Chats</a>
            <a href="#">Buscador Usuarios</a>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['usuario']['rol'] == 'vendedor') {
        ?>
            <a href="/perfil">Perfil</a>
            <a href="#">Chats</a>
            <a href="#">Buscador Usuarios</a>
            <script>
                document.getElementById('logout-link').addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción cerrará tu sesión actual.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, cerrar sesión',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/logout';
                        }
                    });
                });
            </script>
        <?php
        }
        ?>
    </div>
    <div class="sub-bar-search">

        <input type="text" placeholder="Buscar productos..." />
        <button type="submit"><i class="fa fa-search"></i></button>
        <div>
            <a href="/perfil">
                <i class="fa-solid fa-user fa-1x"></i>
            </a>
            <a href="#">
                <i class="fa-solid fa-cart-shopping fa-1x"></i>
            </a>

            <a href="#" id="logout-link"><i class="fa-solid fa-right-from-bracket"></i></a>
            <script>
                document.getElementById('logout-link').addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción cerrará tu sesión actual.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, cerrar sesión',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/logout';
                        }
                    });
                });
            </script>
        </div>

    </div>
</div>