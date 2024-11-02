<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HouseForaneo - Inicio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="logo">HouseForaneo</div>
        <input type="text" class="search-bar" placeholder="Pon tu casa o departamento en HouseForaneo">
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Opciones cuando el usuario está autenticado -->
            <div class="profile-icon">
            <img src="assets/img/perfil.png" alt="Perfil" class="profile-img" onclick="toggleProfileMenu()">
            <div id="profileMenu" class="dropdown-menu">
                    <a href="templates/ver_perfil.php">Ver Perfil</a>
                    <a href="api/logout.php">Cerrar Sesión</a>
                </div>
            </div>
            <div class="settings-icon">
                <img src="assets/img/ajuste.png" alt="Ajustes" class="settings-img" onclick="toggleSettingsMenu()">
                <div id="settingsMenu" class="dropdown-menu">
                    <a href="templates/actualizar_perfil.php">Actualizar Perfil</a>
                    <a href="#" onclick="toggleDarkMode()">Modo Oscuro</a>
                    <a href="templates/informacion.php">Acceder a tu Información</a>
                    <a href="templates/metodo_pago.php">Agregar/Actualizar Método de Pago</a>
                    <a href="templates/cambiar_contrasena.php">Cambiar Contraseña</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Opciones cuando el usuario no ha iniciado sesión -->
            <a href="templates/registro.php" class="btn-signup">Registrarse</a>
            <a href="templates/login.php" class="btn-login">Iniciar Sesión</a>
        <?php endif; ?>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
    <h1><strong>Bienvenido a HouseForaneo</strong></h1>
    <p><em>Encuentra el hogar perfecto mientras estudias lejos de casa.</em></p>
    

        <!-- Tarjetas de propiedades -->
        <section class="listings">
            <!-- Ejemplo de tarjeta de propiedad -->
            <div class="card">
                <img src="assets/img/cuarto1.png" alt="Imagen de la propiedad">
                <div class="card-info">
                    <h3>Cuarto en alquiler</h3>
                    <p>Ciudad de México, 5 estrellas, $5,000 MXN/mes</p>
                </div>
            </div>
            <!-- Más tarjetas de propiedades según sea necesario -->
        </section>

        <div class="more-listings">
            <button>Mostrar más</button>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#">Quiénes somos</a> |
            <a href="#">Descubre</a> |
            <a href="#">Términos y Condiciones</a> |
            <a href="#">Política de Privacidad</a> |
            <a href="#">Nuestro Blog</a>
        </div>
        <p>© 2024 HouseForaneo - Chiapas, Tuxtla Gutiérrez</p>
    </footer>

    <script src="assets/js/scripts.js"></script>
    <script>
        // Función para mostrar/ocultar el menú de perfil
        function toggleProfileMenu() {
            document.getElementById("profileMenu").classList.toggle("show");
        }

        // Función para mostrar/ocultar el menú de ajustes
        function toggleSettingsMenu() {
            document.getElementById("settingsMenu").classList.toggle("show");
        }

        // Cerrar el menú si se hace clic fuera de él
        window.onclick = function(event) {
            if (!event.target.matches('.profile-icon img')) {
                var profileMenu = document.getElementById("profileMenu");
                if (profileMenu && profileMenu.classList.contains('show')) {
                    profileMenu.classList.remove('show');
                }
            }

            if (!event.target.matches('.settings-icon img')) {
                var settingsMenu = document.getElementById("settingsMenu");
                if (settingsMenu && settingsMenu.classList.contains('show')) {
                    settingsMenu.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>
