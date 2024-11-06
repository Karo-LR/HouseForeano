<?php
session_start();
require_once '../config/db.php';

$usuario_id = $_SESSION['usuario_id'];
$query = "SELECT d.*, i.ruta FROM departamentos d 
          LEFT JOIN imagenes_departamento i ON d.id = i.departamento_id 
          WHERE d.usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tus Departamentos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>Tus Departamentos</h2>
    <?php while ($departamento = $result->fetch_assoc()): ?>
        <div class="departamento-card">
            <h3><?php echo $departamento['tipo_propiedad']; ?> en <?php echo $departamento['estado']; ?></h3>
            <p><?php echo $departamento['direccion']; ?></p>
            <p><?php echo "$" . number_format($departamento['precio'], 2) . " MXN/mes"; ?></p>
            <div class="imagenes">
                <?php
                $query_imgs = "SELECT ruta FROM imagenes_departamento WHERE departamento_id = ?";
                $stmt_imgs = $conn->prepare($query_imgs);
                $stmt_imgs->bind_param("i", $departamento['id']);
                $stmt_imgs->execute();
                $imagenes = $stmt_imgs->get_result();
                while ($img = $imagenes->fetch_assoc()):
                ?>
                    <img src="<?php echo $img['ruta']; ?>" alt="Imagen de la propiedad">
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
</body>
</html>
