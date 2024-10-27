<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tipo_usuario = $_POST['tipo_usuario'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $email, $password, $tipo_usuario]);

    echo json_encode(['status' => 'success', 'message' => 'Usuario registrado con éxito']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
