<?php
session_start();

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
require '../config/db.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que la sesión esté activa
    if (!isset($_SESSION['user_id'])) {
        echo "Error: Usuario no autenticado.";
        exit;
    }

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id'];

    // Ejecutar la actualización en la base de datos
    $query = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
    $params = ["ssi", $nombre, $email, $userId];
    $stmt = executeQuery($query, $params);

    // Verificar si la actualización fue exitosa
    if ($stmt) {
        echo "Perfil actualizado con éxito.";
    } else {
        echo "Error al actualizar el perfil: " . $conn->error;
    }
}
?>

<!-- Formulario HTML para actualizar perfil -->
<form action="actualizar_perfil.php" method="post">
    Nombre: <input type="text" name="nombre" required><br>
    Email: <input type="email" name="email" required><br>
    <button type="submit">Actualizar Perfil</button>
</form>
