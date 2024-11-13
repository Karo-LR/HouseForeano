<?php
session_start();
include_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_usuario'])) {
    $mensaje = $_POST['mensaje'];
    $departamento_id = $_POST['departamento_id'];
    $usuario_id = $_SESSION['id_usuario'];

    $sql = "INSERT INTO mensajes (usuario_id, departamento_id, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $usuario_id, $departamento_id, $mensaje);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
