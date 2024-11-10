<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['id_departamento'], $_POST['titulo'], $_POST['descripcion'], $_POST['ciudad'], $_POST['estado'], $_POST['direccion'], $_POST['precio'], $_POST['tipo_propiedad'])) {
    $id_departamento = $_POST['id_departamento'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $direccion = $_POST['direccion'];
    $precio = (float)$_POST['precio'];
    $tipo_propiedad = $_POST['tipo_propiedad'];

    $stmt = $conn->prepare("UPDATE departamentos SET titulo = ?, descripcion = ?, ciudad = ?, estado = ?, direccion = ?, precio = ?, tipo_propiedad = ? WHERE id_departamento = ? AND id_usuario = ?");
    $stmt->bind_param("sssssdiii", $titulo, $descripcion, $ciudad, $estado, $direccion, $precio, $tipo_propiedad, $id_departamento, $id_usuario);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Departamento actualizado exitosamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el departamento: ' . $stmt->error]);
    }    

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios']);
}

$conn->close();
?>
