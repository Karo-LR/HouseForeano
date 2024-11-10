<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['id_departamento'])) {
    $id_departamento = $_POST['id_departamento'];

    // Eliminar imágenes asociadas
    $stmt_img = $conn->prepare("DELETE FROM imagenes_departamento WHERE departamento_id = ?");
    $stmt_img->bind_param("i", $id_departamento);
    $stmt_img->execute();
    $stmt_img->close();

    // Eliminar el departamento
    $stmt = $conn->prepare("DELETE FROM departamentos WHERE id_departamento = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_departamento, $id_usuario);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Departamento eliminado exitosamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el departamento']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios']);
}

$conn->close();
?>
