<?php
session_start();
require_once '../config/db.php'; // Asegúrate de incluir la conexión a la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: usuario no autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Verifica si se recibieron los datos por POST (para moneda o idioma)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los valores enviados por AJAX
    if (isset($_POST['moneda'])) {
        $moneda = $_POST['moneda'];
        // Actualiza la moneda en la base de datos
        $query = "UPDATE preferencias_usuario SET moneda = ? WHERE usuario_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $moneda, $user_id);
        
        if ($stmt->execute()) {
            echo 'success'; // Responde con éxito si la actualización fue correcta
        } else {
            echo 'Error al actualizar la moneda: ' . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['idioma'])) {
        $idioma = $_POST['idioma'];
        // Actualiza el idioma en la base de datos
        $query = "UPDATE preferencias_usuario SET idioma = ? WHERE usuario_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $idioma, $user_id);
        
        if ($stmt->execute()) {
            echo 'success'; // Responde con éxito si la actualización fue correcta
        } else {
            echo 'Error al actualizar el idioma: ' . $stmt->error;
        }
        $stmt->close();
    }
}
?>
