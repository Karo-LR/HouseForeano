<p?php
session_start();
require_once '../config/db.php'; // Esto ya incluye la función executeQuery de db.php

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: usuario no autenticado.");
}

$userId = $_SESSION['usuario_id'];

// Aquí ya puedes usar executeQuery sin volver a declararla
$result = executeQuery("SELECT nombre FROM usuarios WHERE id = ?", [$userId]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la cuenta</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #003580;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 250px;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card h3 {
            color: #003580;
            font-size: 18px;
        }
        .card p {
            font-size: 14px;
            color: #666;
        }
        .card a {
            color: #003580;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Configuración de la cuenta</h1>

        <!-- Tarjetas de configuración -->
        <div class="card">
            <h3>Datos personales</h3>
            <p>Actualiza tus datos y descubre cómo se utilizan.</p>
            <a href="datos_personales.php">Gestionar los datos personales</a>
        </div>

        <div class="card">
            <h3>Ajustes de seguridad</h3>
            <p>Modifica los ajustes de seguridad, configura la autenticación segura o elimina tu cuenta.</p>
            <a href="ajustes_seguridad.php">Gestionar los ajustes de seguridad</a>
        </div>

        <div class="card">
            <h3>Gestión de datos y privacidad</h3>
            <p>Cambiar contraseña</p>
            <p>Recuperar contraseña</p>
            <a href="contraseñas.php">Cambia y/o Recupera tu Contraseña</a>

        </div>

        <div class="card">
            <h3>Opciones de personalización</h3>
            <p>Personaliza tu cuenta para que se adapte a lo que necesitas.</p>
            <a href="preferencias_usuario.php">Gestionar las preferencias</a>
        </div>

        <div class="card">
            <h3>Métodos de pago</h3>
            <p>Añade o elimina métodos de pago para agilizar el proceso de reserva.</p>
            <a href="metodos_pago.php">Gestionar los datos de pago</a>
        </div>


        <div class="card">
            <h3>Dashboard de Administración</h3>
            <p>*Ver todos los usuarios registrados.</p>
            <p>*Asignar o revocar roles a los usuarios.</p>
            <p>*Crear nuevos roles y asignar permisos a estos roles.</p>
            <p>*Consultar un registro de auditoría para ver las acciones realizadas por los usuarios.</p>
            <a href="panel_administracion.php">Panel de administración para los administradores.</a><br>
        </div>
           
    </div>
</body>
</html>
