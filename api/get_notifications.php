<?php
session_start();
require_once '../config/db.php';

$id_usuario = $_SESSION['id_usuario']; // ID del usuario que está consultando

// Consulta para contar los mensajes sin leer en propiedades del usuario
$query = "
    SELECT COUNT(*) AS unseen_count 
    FROM mensajes m
    JOIN departamentos d ON m.departamento_id = d.id_departamento
    WHERE d.usuario_id = ? AND m.leido = FALSE
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode([
    "unseen_count" => $data['unseen_count']
]);

$stmt->close();
$conn->close();
?>
