<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensaje = $_POST['mensaje'];
    $usuario = $_POST['usuario'];
    $departamento_id = $_POST['departamento'];

    $query = "INSERT INTO mensajes (mensaje, usuario, departamento_id, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $mensaje, $usuario, $departamento_id);

    if ($stmt->execute()) {
        echo "Mensaje guardado correctamente.";
    } else {
        echo "Error al guardar el mensaje.";
    }
}
?>
