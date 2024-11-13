<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['to_user_id'], $_POST['property_id'], $_POST['message'])) {
    $from_user_id = $_SESSION['user_id'];
    $to_user_id = $_POST['to_user_id'];
    $property_id = $_POST['property_id'];
    $message = $_POST['message'];

    // Inserta el mensaje
    $stmt = $conn->prepare("INSERT INTO mensajes (from_user_id, to_user_id, property_id, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $from_user_id, $to_user_id, $property_id, $message);
    $stmt->execute();

    // Obtiene el último ID insertado de mensaje y crea la notificación
    $message_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO notificaciones (user_id, message_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $to_user_id, $message_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
}
?>
