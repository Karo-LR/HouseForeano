<?php
session_start();
require_once '../config/db.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .admin-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .admin-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .admin-container a {
            display: block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .admin-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Panel de Administración</h1>
        <a href="ver_usuarios.php">Ver todos los usuarios registrados</a>
        <a href="gestionar_roles.php">Asignar o revocar roles a los usuarios</a>
        <a href="crear_roles_permisos.php">Crear nuevos roles y asignar permisos a estos roles</a>
        <a href="registro_auditoria.php">Consultar un registro de auditoría</a>
    </div>
</body>
</html>