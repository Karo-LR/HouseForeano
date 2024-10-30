<?php
require '../config/db.php';

// Crear conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Realizar la consulta
$sql = "SELECT * FROM departamentos";
$result = $conn->query($sql);

$departamentos = [];

if ($result->num_rows > 0) {
    // Almacenar resultados en un array
    while ($row = $result->fetch_assoc()) {
        $departamentos[] = $row;
    }
}

// Devolver respuesta en formato JSON
echo json_encode(['status' => 'success', 'departamentos' => $departamentos]);

// Cerrar conexión
$conn->close();
?>
