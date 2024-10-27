<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $ubicacion_lat = $_POST['ubicacion_lat'];
    $ubicacion_lng = $_POST['ubicacion_lng'];

    $stmt = $pdo->prepare("INSERT INTO departamentos (usuario_id, direccion, descripcion, precio, ubicacion_lat, ubicacion_lng) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $direccion, $descripcion, $precio, $ubicacion_lat, $ubicacion_lng]);

    echo json_encode(['status' => 'success', 'message' => 'Departamento agregado con éxito']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
