<?php
include '../config/db.php';

$to_user_id = $_POST['to_user_id']; // Se debe definir o recibir el ID del usuario
$message_id = $_POST['message_id']; // Asumimos que recibes el ID del mensaje por POST

// Insertar en la tabla de notificaciones
$notificationQuery = "INSERT INTO notificaciones (user_id, message_id) VALUES (?, ?)";
$notificationStmt = $conn->prepare($notificationQuery);
$notificationStmt->bind_param("ii", $to_user_id, $message_id);

if ($notificationStmt->execute()) {
    echo "Notificación creada exitosamente";
} else {
    echo "Error al crear la notificación: " . $conn->error;
}
?>
