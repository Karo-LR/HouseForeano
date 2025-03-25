<?php
session_start();
include_once '../config/db.php';

// Verificar rol de editor
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Editor') {
    echo "Acceso denegado.";
    exit;
}

// ... (Lógica para gestionar departamentos, imágenes, etc.)

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestión de Contenido</title>
    </head>
<body>
    <h1>Gestión de Contenido</h1>

    <h2>Departamentos</h2>
    <h2>Imágenes</h2>
    </body>
</html>