<?php
session_start();
require_once '../config/db.php';

$id_departamento = $_POST['id_departamento'];
$id_emisor = $_SESSION['id_usuario'];
$id_receptor = $_POST['id_receptor'];
$mensaje = $_POST['mensaje'];

$query = "INSERT INTO mensajes (id_departamento, id_emisor, id_receptor, mensaje) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiis", $id_departamento, $id_emisor, $id_receptor, $mensaje);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>
