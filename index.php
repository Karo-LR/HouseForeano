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
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
    <!-- Encabezado -->
    <header class="header">
    <a href="/" class="home-icon">
        <i class="fas fa-home"></i> <!-- Ícono de la casita -->
    </a>
        <div class="logo">HouseForaneo</div>
        <input type="text" class="search-bar" placeholder="Pon tu casa o departamento en HouseForaneo">
        
        <?php if (isset($_SESSION['usuario'])): ?>
            <!-- Opciones cuando el usuario está autenticado -->
            <div class="user-info">
                <p> <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
            </div>
            <div class="profile-icon">
                <img src="assets/img/perfil.png" alt="Perfil" class="profile-img" onclick="toggleProfileMenu()">
                <div id="profileMenu" class="dropdown-menu">
                    <a href="templates/ver_perfil.php">Ver Perfil</a>
                    <a href="templates/ver_perfil.php">Configuración</a>
                    <a href="api/logout.php">Cerrar Sesión</a>
                </div>
            </div>
            <div class="user-actions">
                <a href="templates/mis_departamentos.php" class="btn">Mis Departamentos</a>
                <a href="templates/subir_departamento.php" class="btn">Subir Departamento</a>
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

        <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank">
            <img src="assets/img/facebook-icon.png" alt="Facebook">
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <img src="assets/img/instagram-icon.png" alt="Instagram">
        </a>
        <a href="https://www.tiktok.com" target="_blank">
            <img src="assets/img/tiktok-icon.png" alt="TikTok">
        </a>
        <a href="https://www.whatsapp.com" target="_blank">
            <img src="assets/img/whatsapp-icon.png" alt="WhatsApp">
        </a>
         </div>            
        </div>
        <p>© 2024 HouseForaneo - Chiapas, Tuxtla Gutiérrez</p>
    </footer>

    <script src="assets/js/scripts.js"></script>
    <script>
        // Función para mostrar/ocultar el menú de perfil
        function toggleProfileMenu() {
            document.getElementById("profileMenu").classList.toggle("show");
        }

        // Función para cerrar los menús si se hace clic fuera de ellos
        window.onclick = function(event) {
            if (!event.target.matches('.profile-img')) {
                var profileMenu = document.getElementById("profileMenu");
                if (profileMenu && profileMenu.classList.contains('show')) {
                    profileMenu.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>
