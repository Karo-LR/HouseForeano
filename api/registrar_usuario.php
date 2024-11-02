<?php
require '../config/db.php';
session_start(); // Inicia la sesión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tipo_usuario = $_POST['tipo_usuario'];

    // Preparar la inserción del nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $password, $tipo_usuario);
    
    if ($stmt->execute()) {
        // Guardar el nombre del usuario en la sesión
        $_SESSION['usuario'] = $nombre;
        
        // Redirigir a la página de bienvenida
        header("Location: ../templates/welcome.php");
        exit(); // Detiene el script después de la redirección
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuario']);
    }

    $stmt->close();
    $conn->close(); // Cierra la conexión a la base de datos
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
