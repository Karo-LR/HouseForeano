<?php
require_once '../config/db.php';

$departamento_id = intval($_GET['departamento_id']);

$query = "SELECT mensaje, user_type FROM mensajes WHERE departamento_id = ? ORDER BY fecha_enviado ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $departamento_id);
$stmt->execute();
$result = $stmt->get_result();

$mensajes = [];
while ($row = $result->fetch_assoc()) {
    $mensajes[] = $row;
}

echo json_encode($mensajes);
