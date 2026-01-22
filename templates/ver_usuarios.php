<?php
session_start();
require_once '../config/db.php';

// Obtener todos los usuarios
$stmt = executeQuery("SELECT id, nombre, email FROM usuarios", []);
$result = $stmt->get_result(); // Obtener el resultado de la consulta

if ($result) {
    $usuarios = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $usuarios = []; // En caso de error, inicializar $usuarios como un array vacío
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios Registrados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #6d0000;
        }
    </style>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>