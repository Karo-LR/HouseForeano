<?php
require '../config/db.php';

$searchTerm = $_GET['search'] ?? '';

// Prepara la consulta SQL con el término de búsqueda
$sql = "
    SELECT d.*, i.ruta_imagen 
    FROM departamentos d
    LEFT JOIN imagenes_departamento i ON d.id_departamento = i.departamento_id
    WHERE d.titulo LIKE ? OR d.descripcion LIKE ? OR d.ciudad LIKE ? OR d.estado LIKE ?
    GROUP BY d.id_departamento
";

$stmt = $conn->prepare($sql);
$searchParam = "%" . $searchTerm . "%";
$stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Muestra los resultados
while ($row = $result->fetch_assoc()) {
    echo "<div class='card'>";
    echo "<img src='" . htmlspecialchars($row['ruta_imagen']) . "' alt='Imagen de la propiedad'>";
    echo "<div class='card-info'>";
    echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
    echo "<p>" . htmlspecialchars($row['ciudad']) . ", " . htmlspecialchars($row['estado']) . "</p>";
    echo "<p>Precio: $" . htmlspecialchars($row['precio']) . " MXN/mes</p>";
    echo "</div>";
    echo "</div>";
}
?>
