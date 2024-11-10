<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$id_departamento = $_GET['id'] ?? null;

if (!$id_departamento) {
    echo "Error: Departamento no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Departamento</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>¿Estás seguro de que deseas eliminar este departamento?</h2>
    <form action="../api/eliminar_departamento.php" method="POST">
        <input type="hidden" name="id_departamento" value="<?php echo $id_departamento; ?>">
        <button type="submit">Sí, eliminar</button>
        <a href="mis_departamentos.php">No, volver</a>
    </form>
</body>
</html>
