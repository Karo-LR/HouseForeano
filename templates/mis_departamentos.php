<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// Consulta para obtener departamentos del usuario autenticado
$query = "SELECT d.*, i.ruta_imagen 
          FROM departamentos d 
          LEFT JOIN imagenes_departamento i ON d.id_departamento = i.departamento_id 
          WHERE d.id_usuario = ? 
          GROUP BY d.id_departamento";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit();
}

$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo "Error en la ejecución de la consulta: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Departamentos</title>
</head>
<body>
    <h1>Mis Departamentos</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($row['ruta_imagen'] ?? '../assets/img/default.png'); ?>" alt="Imagen de la propiedad">
                <div class="card-info">
                    <h3><?php echo htmlspecialchars($row['tipo_propiedad']); ?> en alquiler</h3>
                    <p><?php echo htmlspecialchars($row['direccion']); ?>, <?php echo htmlspecialchars($row['estado']); ?></p>
                    <p><?php echo "$" . number_format($row['precio'], 2) . " MXN/mes"; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No tienes departamentos agregados.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
