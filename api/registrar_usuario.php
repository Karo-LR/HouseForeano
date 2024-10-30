<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tipo_usuario = $_POST['tipo_usuario'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $password, $tipo_usuario);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Usuario registrado con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuario']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
