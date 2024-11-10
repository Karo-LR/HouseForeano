<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: usuario no autenticado.");
}

$userId = $_SESSION['usuario_id'];

// Consulta los datos del usuario
$query = "SELECT nombre, email FROM usuarios WHERE id = ?";
$stmt = executeQuery($query, [$userId]);

if ($stmt === false) {
    die("Error en la consulta: " . $conn->error);
}

$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($userData) {
    $nombre = $userData['nombre'];
    $email = $userData['email'];
} else {
    $nombre = "No disponible";
    $email = "No disponible";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de enlazar el archivo CSS -->
    <style>
        /* Estilos para la tarjeta de perfil */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .perfil-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .perfil-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 3px solid #007bff;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }


        .user-info {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .user-info p {
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <div class="perfil-container">
        <h1>Mi Perfil</h1>
        <!-- Imagen de perfil opcional -->
        <div class="profile-pic">
    <img src="../assets/img/pollito.gif" alt="GIF de perfil">
    </div>

        <!-- Información del usuario -->
        <div class="user-info">
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>
</body>
</html>
