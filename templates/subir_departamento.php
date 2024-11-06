<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Departamento</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>Subir un nuevo departamento</h2>
    <form action="../api/agregar_departamento.php" method="POST" enctype="multipart/form-data">
        <label for="estado">Estado:</label>
        <input type="text" name="estado" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>

        <label for="tipo_propiedad">Tipo de propiedad:</label>
        <select name="tipo_propiedad" required>
            <option value="cuarto">Cuarto</option>
            <option value="departamento">Departamento</option>
            <option value="casa">Casa</option>
        </select>

        <label for="precio">Precio (MXN/mes):</label>
        <input type="number" name="precio" required>

        <label for="imagenes">Imágenes (puedes subir varias):</label>
        <input type="file" name="imagenes[]" multiple required>

        <button type="submit">Subir Departamento</button>
    </form>
</body>
</html>
