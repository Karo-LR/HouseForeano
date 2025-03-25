<?php
include('config.php');

$departamento_id = $_GET['departamento_id'];

$query = "SELECT * FROM mensajes WHERE departamento_id = ? ORDER BY fecha ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $departamento_id);
$stmt->execute();
$resultado = $stmt->get_result();

while ($mensaje = $resultado->fetch_assoc()) {
    echo "<div><strong>" . htmlspecialchars($mensaje['usuario']) . ":</strong> " . htmlspecialchars($mensaje['mensaje']) . "<br><small>" . $mensaje['fecha'] . "</small></div>";
}
?>
