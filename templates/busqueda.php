<?php
session_start();
require '../config/db.php';

$searchTerm = $_GET['search'] ?? '';
$userId = $_SESSION['usuario_id'] ?? null; // Asegúrate de que la sesión tenga el ID del usuario actual.

// Prepara la consulta SQL con el término de búsqueda y excluye propiedades del usuario actual
$sql = "
    SELECT d.*, i.ruta_imagen 
    FROM departamentos d
    LEFT JOIN imagenes_departamento i ON d.id_departamento = i.departamento_id
    WHERE (d.titulo LIKE ? OR d.descripcion LIKE ? OR d.ciudad LIKE ? OR d.estado LIKE ?)
";

if ($userId) {
    $sql .= " AND d.id_usuario != ?"; // Excluye las propiedades del usuario actual
}

$sql .= " GROUP BY d.id_departamento";

$stmt = $conn->prepare($sql);
$searchParam = "%" . $searchTerm . "%";

if ($userId) {
    $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $userId);
} else {
    $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - HouseForaneo</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Resultados de Búsqueda</h1>
    <section class="listings">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <a href="detalle_departamento.php?id=<?php echo $row['id_departamento']; ?>" class="card-link">
                <div class="card">
                    <img src="<?php echo $row['ruta_imagen'] ? '../assets/img/' . htmlspecialchars($row['ruta_imagen']) : '../assets/img/default.jpg'; ?>" alt="Imagen de la propiedad">
                    <div class="card-info">
                        <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($row['ciudad']) . ', ' . htmlspecialchars($row['estado']); ?></p>
                        <p>Precio: $<?php echo number_format($row['precio'], 2); ?> MXN/mes</p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </section>
</body>
</html>
