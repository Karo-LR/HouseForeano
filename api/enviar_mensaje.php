<?php
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id_departamento = intval($data['id_departamento']);
$mensaje = htmlspecialchars($data['mensaje']);
$user_type = $_SESSION['usuario_id'] == $departamento['id_usuario'] ? 'propietario' : 'interesado';

$query = "INSERT INTO mensajes (departamento_id, mensaje, user_type, fecha_enviado) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $id_departamento, $mensaje, $user_type);
$stmt->execute();
$stmt->close();
?>
