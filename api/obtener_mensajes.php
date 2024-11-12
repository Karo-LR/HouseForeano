<?php
require_once '../config/db.php';
$departamento_id = $_GET['departamento_id'];

$query = "SELECT u.nombre, m.mensaje, m.fecha_envio FROM mensajes m JOIN usuarios u ON m.usuario_id = u.id_usuario WHERE m.departamento_id = ? ORDER BY m.fecha_envio ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $departamento_id);
$stmt->execute();
$result = $stmt->get_result();

$mensajes = [];
while ($row = $result->fetch_assoc()) {
    $mensajes[] = $row;
}

echo json_encode($mensajes);
$stmt->close();
$conn->close();
?>
