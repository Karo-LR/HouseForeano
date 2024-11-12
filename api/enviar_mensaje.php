<?php
session_start();
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$mensaje = $data['mensaje'];
$departamento_id = $data['departamento_id'];
$id_usuario = $_SESSION['id_usuario']; // Usuario que envía el mensaje

$query = "INSERT INTO mensajes (departamento_id, usuario_id, mensaje, fecha_envio) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $departamento_id, $id_usuario, $mensaje);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Error al enviar el mensaje"]);
}
$stmt->close();
$conn->close();
?>
