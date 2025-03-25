<?php
session_start();
require_once '../config/db.php';

// Obtener el ID del departamento
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "ID de departamento inválido.";
    exit;
}

// Consulta para obtener detalles del departamento
$query = "SELECT * FROM departamentos WHERE id_departamento = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Departamento no encontrado.";
    exit;
}

$departamento = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($departamento['titulo']); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #0E2C40; padding: 40px 0;">

<div style="max-width: 800px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #333;"><?php echo htmlspecialchars($departamento['titulo']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($departamento['descripcion'])); ?></p>
    <p><strong>Dirección:</strong> 
        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($departamento['direccion']); ?>" target="_blank">
            <?php echo htmlspecialchars($departamento['direccion']); ?>
        </a>
    </p>

    <!-- Mapa de Google Maps utilizando iframe -->
    <div style="margin-top: 20px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1910.2619995056853!2d-93.0930048114147!3d16.750585946008027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ed277927b03bab%3A0x697cbc938f527a60!2sReal%20del%20Bosque%2C%2029040%20Tuxtla%20Guti%C3%A9rrez%2C%20Chis.!5e0!3m2!1ses-419!2smx!4v1731501430604!5m2!1ses-419!2smx" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <p><strong>Precio:</strong> $<?php echo number_format($departamento['precio'], 2); ?></p>

    <!-- Galería de imágenes -->
    <div class="galeria" style="display: flex; gap: 10px; margin-top: 20px;">
        <?php
        $query_imagenes = "SELECT * FROM imagenes_departamento WHERE departamento_id = ?";
        $stmt_imagenes = $conn->prepare($query_imagenes);
        $stmt_imagenes->bind_param("i", $id);
        $stmt_imagenes->execute();
        $resultado_imagenes = $stmt_imagenes->get_result();

        if ($resultado_imagenes->num_rows > 0) {
            while ($imagen = $resultado_imagenes->fetch_assoc()) {
                $rutaImagen = '../uploads/' . htmlspecialchars($imagen['ruta_imagen']);
                echo "<img src='$rutaImagen' alt='Imagen del departamento' style='width: 100px; height: auto; border-radius: 8px;'>";
            }
        } else {
            echo "<p>No hay imágenes disponibles para este departamento.</p>";
        }
        ?>
    </div>

    <!-- Botón para abrir el chat -->
    <button onclick="abrirChat(event)" style="margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Contactar al Rentatario</button>
</div>

<!-- Contenedor del chat -->
<div id="chatContainer" class="chat-hidden">
    <div class="chat-header">
        <h3>Chat con el Rentatario</h3>
        <button onclick="cerrarChat()">X</button>
    </div>
    <div id="chatMessages" class="chat-messages"></div>
    <input type="text" id="chatInput" placeholder="Escribe un mensaje..." onkeypress="enviarMensaje(event)">
</div>

<!-- Estilos de la página y el chat -->
<style>
    /* Estilos del contenedor y mensajes del chat */
    .chat-hidden {
        display: none;
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 350px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        font-family: Arial, sans-serif;
    }

    .chat-header {
        background: #007bff;
        color: #ffffff;
        padding: 12px;
        font-size: 1.1em;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .chat-header button {
        background: none;
        border: none;
        color: #ffffff;
        font-size: 1em;
        cursor: pointer;
    }

    .chat-messages {
        padding: 15px;
        max-height: 300px;
        overflow-y: auto;
        font-size: 0.9em;
        color: #333;
    }

    .user-message {
        text-align: right;
        background-color: #d1e7ff;
        color: #0056b3;
        padding: 8px;
        margin: 5px 0;
        border-radius: 8px;
        max-width: 80%;
        margin-left: auto;
    }

    .rentatario-message {
        text-align: left;
        background-color: #e8f5e9;
        color: #2e7d32;
        padding: 8px;
        margin: 5px 0;
        border-radius: 8px;
        max-width: 80%;
        margin-right: auto;
    }

    #chatInput {
        width: 100%;
        padding: 10px;
        border: none;
        border-top: 1px solid #ddd;
        font-size: 1em;
        box-sizing: border-box;
        outline: none;
    }

    #chatInput::placeholder {
        color: #aaa;
    }
</style>

<!-- JavaScript para el chat -->
<script>
function abrirChat(event) {
    event.preventDefault();
    document.getElementById("chatContainer").style.display = "block";

    fetch("../api/obtener_mensajes.php?departamento_id=<?php echo $id; ?>")
        .then(response => response.json())
        .then(data => {
            const chatMessages = document.getElementById("chatMessages");
            chatMessages.innerHTML = "";
            data.forEach(msg => {
                const p = document.createElement("p");
                p.classList.add(msg.user_type === "user" ? "user-message" : "rentatario-message");
                p.textContent = msg.mensaje;
                chatMessages.appendChild(p);
            });
        });
}

function cerrarChat() {
    document.getElementById("chatContainer").style.display = "none";
}

function enviarMensaje(event) {
    if (event.key === 'Enter') {
        const messageInput = document.getElementById("chatInput");
        const message = messageInput.value.trim();

        if (message) {
            fetch("../api/enviar_mensaje.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id_departamento: <?php echo $id; ?>,
                    mensaje: message
                })
            }).then(() => {
                const p = document.createElement("p");
                p.classList.add("user-message");
                p.textContent = message;
                document.getElementById("chatMessages").appendChild(p);
                messageInput.value = ""; // Limpia el input
            });
        }
    }
}
</script>

</body>
</html>
