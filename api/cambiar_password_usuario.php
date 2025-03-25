<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Usuario no autenticado.");
}

// Obtener datos del formulario
$usuarioId = $_SESSION['usuario_id'];
$passwordNuevo = $_POST['password_nuevo'] ?? '';

// Validar datos
if (empty($passwordNuevo)) {
    die("La nueva contraseña es obligatoria.");
}

// Hash de la nueva contraseña
$passwordNuevoHash = password_hash($passwordNuevo, PASSWORD_DEFAULT);

// Actualizar la contraseña en la base de datos
executeQuery("UPDATE usuarios SET password = ? WHERE id = ?", [$passwordNuevoHash, $usuarioId]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Actualizada</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #e0b0ff; /* Lila pastel */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #f8f0ff; /* Lila claro */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #800080; /* Lila oscuro */
            margin-bottom: 20px;
        }

        p {
            color: #333;
            margin-bottom: 30px;
        }

        a {
            background-color: #c8a2c8; /* Lila medio */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #a080a0; /* Lila más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contraseña Actualizada</h1>
        <p>Tu contraseña se ha actualizado correctamente.</p>
        <a href="../templates/login.php">Iniciar Sesión</a>
    </div>
</body>
</html>