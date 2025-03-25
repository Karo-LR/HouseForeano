<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// Consulta para obtener departamentos del usuario autenticado
$query = "
    SELECT d.id_departamento, d.tipo_propiedad, d.direccion, d.estado, d.precio
    FROM departamentos d
    WHERE d.id_usuario = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Departamentos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Estilos del carrusel e interfaz */
        .page-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .button-group {
            margin-bottom: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            margin: 10px auto;
            text-align: left;
            display: inline-block;
            vertical-align: top;
        }
        .carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .carousel img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .carousel-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .carousel-buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .card-info {
            padding: 15px;
        }
        .card-info h3 {
            font-size: 18px;
            margin: 0;
        }
        .card-info p {
            margin: 5px 0;
            color: #555;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .action-buttons a {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .action-buttons a:first-child {
            background-color: #4CAF50;
        }
        .action-buttons a.delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <h1>Mis Departamentos</h1>

        <div class="button-group">
            <a href="subir_departamento.php" class="button button-primary">Subir otro departamento</a>
            <a href="../index.php" class="button button-secondary">Volver al Inicio</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="carousel">
                        <?php
                        // Obtener todas las imágenes para este departamento
                        $imageQuery = "SELECT ruta_imagen FROM imagenes_departamento WHERE departamento_id = ?";
                        $imageStmt = $conn->prepare($imageQuery);
                        $imageStmt->bind_param("i", $row['id_departamento']);
                        $imageStmt->execute();
                        $imageResult = $imageStmt->get_result();
                        if ($imageResult->num_rows > 0):
                            while ($imageRow = $imageResult->fetch_assoc()): ?>
                                <img src="../assets/img/<?php echo htmlspecialchars($imageRow['ruta_imagen']); ?>" class="carousel-image" alt="Imagen de la propiedad">
                            <?php endwhile;
                        else: ?>
                            <!-- Imagen por defecto si no hay imágenes en la base de datos -->
                            <img src="../assets/img/default.png" alt="Imagen no disponible">
                        <?php endif; ?>
                        <div class="carousel-buttons">
                            <button class="prev">Anterior</button>
                            <button class="next">Siguiente</button>
                        </div>
                    </div>

                    <div class="card-info">
                        <h3><?php echo htmlspecialchars($row['tipo_propiedad']); ?> en alquiler</h3>
                        <p><?php echo htmlspecialchars($row['direccion']); ?>, <?php echo htmlspecialchars($row['estado']); ?></p>
                        <p><?php echo "$" . number_format($row['precio'], 2) . " MXN/mes"; ?></p>
                    </div>
                    <div class="action-buttons">
                        <a href="editar_departamento.php?id=<?php echo $row['id_departamento']; ?>">Editar</a>
                        <a href="eliminar_departamento.php?id=<?php echo $row['id_departamento']; ?>" class="delete">Eliminar</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes departamentos agregados.</p>
        <?php endif; ?>

        <?php
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <div class="chat-container" id="chat-<?php echo $row['id_departamento']; ?>">
    <h4>Chat con interesados</h4>
    <div class="chat-messages" id="messages-<?php echo $row['id_departamento']; ?>">
        <!-- Los mensajes se cargarán aquí -->
    </div>
    <textarea id="inputMessage-<?php echo $row['id_departamento']; ?>" placeholder="Escribe un mensaje..."></textarea>
    <button onclick="sendMessage(<?php echo $row['id_departamento']; ?>)">Enviar</button>
</div>
<style>
   .chat-container {
    border: 1px solid #ddd;
    padding: 10px;
    margin-top: 10px;
}
.chat-messages {
    height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 5px;
    margin-bottom: 10px;
}
textarea {
    width: 100%;
    resize: none;
}
 
</style>

    <script src="../assets/js/carousel.js"></script>
</body>
</html>
