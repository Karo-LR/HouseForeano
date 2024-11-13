<?php
session_start();
require_once '../config/db.php'; // Esto ya incluye la función executeQuery de db.php

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: usuario no autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Consulta la moneda e idioma actual del usuario
$query = "SELECT moneda, idioma FROM preferencias_usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($moneda_actual, $idioma_actual);

// Verificar si se encontraron resultados
if ($stmt->fetch()) {
    // Si no se encuentran valores en la consulta, asignar valores predeterminados
    $moneda_actual = $moneda_actual ?: 'MXN';
    $idioma_actual = $idioma_actual ?: 'en';
} else {
    // Asignar valores predeterminados en caso de que no haya registro para el usuario
    $moneda_actual = 'MXN';
    $idioma_actual = 'en';
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preferencias de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #0E2C40;
            margin-bottom: 20px;
        }
        .preference-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .preference-item:last-child {
            border-bottom: none;
        }
        .preference-item span {
            font-weight: bold;
        }
        .preference-item form {
            display: flex;
            align-items: center;
        }
        .preference-item select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .save-btn {
            background-color: #0E2C40;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9em;
        }
        .save-btn:hover {
            background-color: #ff5a5f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Preferencias de Usuario</h2>
        
        <!-- Moneda -->
        <div class="preference-item">
            <span>Moneda:</span>
            <form id="form-moneda">
                <select name="moneda" id="moneda">
                    <option value="MXN" <?= $moneda_actual === 'MXN' ? 'selected' : '' ?>>MXN - Mexican Peso</option>
                    <option value="USD" <?= $moneda_actual === 'USD' ? 'selected' : '' ?>>USD - US Dollar</option>
                    <option value="EUR" <?= $moneda_actual === 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
                    <!-- Agrega más opciones si es necesario -->
                </select>
                <button type="submit" class="save-btn">Guardar Cambios</button>
            </form>
        </div>

        <!-- Idioma -->
        <div class="preference-item">
            <span>Idioma:</span>
            <form id="form-idioma">
                <select name="idioma" id="idioma">
                    <option value="es" <?= $idioma_actual === 'es' ? 'selected' : '' ?>>Español</option>
                    <option value="en" <?= $idioma_actual === 'en' ? 'selected' : '' ?>>Inglés</option>
                    <option value="fr" <?= $idioma_actual === 'fr' ? 'selected' : '' ?>>Francés</option>
                    <!-- Agrega más idiomas si es necesario -->
                </select>
                <button type="submit" class="save-btn">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- Incluye jQuery para usar AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        // Manejo de la actualización de moneda
        $('#form-moneda').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario

            var moneda = $('#moneda').val(); // Obtener la moneda seleccionada

            $.ajax({
                url: 'editar_preferencias.php', // La página que actualizará la base de datos
                type: 'POST',
                data: {
                    moneda: moneda // Enviar la moneda seleccionada
                },
                success: function(response) {
                    // Aquí manejamos la respuesta
                    if (response.trim() === 'success') {
                        alert('Moneda actualizada con éxito');
                        // Opcional: Actualizar la moneda en la interfaz si es necesario
                    } else {
                        alert('Error al actualizar la moneda: ' + response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX: ' + error);
                }
            });
        });

        // Manejo de la actualización de idioma
        $('#form-idioma').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario

            var idioma = $('#idioma').val(); // Obtener el idioma seleccionado

            $.ajax({
                url: 'editar_preferencias.php', // La página que actualizará la base de datos
                type: 'POST',
                data: {
                    idioma: idioma // Enviar el idioma seleccionado
                },
                success: function(response) {
                    // Aquí manejamos la respuesta
                    if (response.trim() === 'success') {
                        alert('Idioma actualizado con éxito');
                        // Opcional: Actualizar el idioma en la interfaz si es necesario
                    } else {
                        alert('Error al actualizar el idioma: ' + response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX: ' + error);
                }
            });
        });
    });
    </script>
</body>
</html>
