<?php
require '../config/db.php';
session_start(); // Inicia la sesión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $tipo_usuario = $_POST['tipo_usuario'];

<<<<<<< HEAD
    // Verificación de que las contraseñas coincidan
    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo.']);
        exit;
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

=======
    // Preparar la inserción del nuevo usuario
>>>>>>> 20347ead5e4240e14278697246a894381b78206c
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $tipo_usuario);

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
