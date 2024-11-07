<?php
require '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $tipo_usuario = $_POST['tipo_usuario'];

    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden.']);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $tipo_usuario);

    if ($stmt->execute()) {
        $nuevo_usuario_id = $conn->insert_id;
        $_SESSION['usuario_id'] = $nuevo_usuario_id;
        $_SESSION['usuario'] = $nombre;
        
        header("Location: ../templates/welcome.php");
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuario']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
