<?php
session_start();
include_once 'config/db.php';

// Verificar si el usuario ha iniciado sesión
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

if ($id_usuario) {
    // Si el usuario ha iniciado sesión, excluir sus propias propiedades
    $sql = "SELECT d.*, i.ruta_imagen 
            FROM departamentos d 
            LEFT JOIN imagenes_departamento i ON d.id_departamento = i.departamento_id 
            WHERE d.tipo_propiedad = 'casa' 
            AND d.id_usuario != ? 
            GROUP BY d.id_departamento 
            ORDER BY d.fecha_publicacion DESC 
            LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si el usuario no ha iniciado sesión, mostrar todas las propiedades de tipo 'casa'
    $sql = "SELECT d.*, i.ruta_imagen 
            FROM departamentos d 
            LEFT JOIN imagenes_departamento i ON d.id_departamento = i.departamento_id 
            WHERE d.tipo_propiedad = 'casa' 
            GROUP BY d.id_departamento 
            ORDER BY d.fecha_publicacion DESC 
            LIMIT 10";
    $result = $conn->query($sql);
}
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
    
<!-- ENCABEZADO -->
<header class="header">
    <div class="logo-container">
        <a href="/" class="home-icon">
            <i class="fas fa-home"></i>
        </a>
        <div class="logo">HouseForaneo</div>
    </div>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="templates/busqueda.php" style="display:inline;">
        <input type="text" name="search" class="search-bar" placeholder="Pon tu casa en HouseForaneo">
        <button type="submit" class="search-button">Buscar</button>
    </form>

    <?php if (isset($_SESSION['usuario'])): ?>
        <div class="user-info">
            <div class="user-name-container">
                <p class="user-name"><?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
                <img src="assets/img/perfil.png" alt="Perfil" class="profile-img" onclick="toggleProfileMenu()">
            </div>
            <div id="profileMenu" class="dropdown-menu">
                <a href="templates/gestionar_cuenta.php">Gestionar Cuenta</a>
                <a href="api/logout.php">Cerrar Sesión</a>
            </div>
        </div>
        
        <div class="user-actions">
            <a href="templates/mis_departamentos.php" class="btn">Mis Departamentos</a>
            <a href="templates/subir_departamento.php" class="btn">Subir Departamento</a>
        </div>
    <?php else: ?>
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
            <?php while ($row = $result->fetch_assoc()) { ?>
                <a href="templates/detalle_departamento.php?id=<?php echo $row['id_departamento']; ?>" class="card-link">
                    <div class="card">
                        <img src="<?php echo $row['ruta_imagen'] ? 'assets/img/' . $row['ruta_imagen'] : 'assets/img/default.jpg'; ?>" alt="Imagen de la propiedad">
                        <div class="card-info">
                            <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars($row['ciudad']) . ', ' . htmlspecialchars($row['estado']); ?></p>
                            <p><?php echo "$" . number_format($row['precio'], 2) . " MXN/mes"; ?></p>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </section>
    </main>



    
    <!-- Pie de página -->
    <footer class="footer">
        <div class="footer-links">
            <a href="https://www.facebook.com" target="_blank">
                <img src="assets/img/facebook.png" alt="Facebook">
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <img src="assets/img/instagram.png" alt="Instagram">
            </a>
            <a href="https://www.tiktok.com" target="_blank">
                <img src="assets/img/tiktok.png" alt="TikTok">
            </a>
            <a href="https://www.whatsapp.com" target="_blank">
                <img src="assets/img/whatsapp.png" alt="WhatsApp">
            </a>
        </div> 
        <a href="#">Quiénes somos</a> |
        <a href="#">Descubre</a> |
        <a href="#">Términos y Condiciones</a> |
        <a href="#">Política de Privacidad</a> |
        <a href="#">Nuestro Blog</a>
        <p>© 2024 HouseForaneo - Chiapas, Tuxtla Gutiérrez</p>
    </footer>

    <script src="assets/js/scripts.js"></script>
    <script>
        function toggleProfileMenu() {
            document.getElementById("profileMenu").classList.toggle("show");
        }

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
 