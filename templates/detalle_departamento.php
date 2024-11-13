<?php
session_start();
require_once '../config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "ID de departamento inválido.";
    exit;
}

$query = "SELECT * FROM departamentos WHERE id_departamento = $id";
$resultado = mysqli_query($conn, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo "Departamento no encontrado.";
    exit;
}

$departamento = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($departamento['titulo']); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #f7f7f7;">

<div style="max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #333;"><?php echo htmlspecialchars($departamento['titulo']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($departamento['descripcion'])); ?></p>
    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($departamento['direccion']); ?></p>
    <p><strong>Precio:</strong> $<?php echo number_format($departamento['precio'], 2); ?></p>

    <!-- Muestra el mapa -->
    <div id="map" style="width:100%; height:400px; margin-top: 20px;"></div>
    <script>
        function initMap() {
            var ubicacion = { lat: <?php echo $departamento['latitud']; ?>, lng: <?php echo $departamento['longitud']; ?> };
            var map = new google.maps.Map(document.getElementById('map'), { zoom: 15, center: ubicacion });
            new google.maps.Marker({ position: ubicacion, map: map });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

    <!-- Galería de imágenes -->
    <div class="galeria" style="display: flex; gap: 10px; margin-top: 20px;">
        <?php
        $query_imagenes = "SELECT * FROM imagenes_departamento WHERE departamento_id = $id";
        $resultado_imagenes = mysqli_query($conn, $query_imagenes);

        if ($resultado_imagenes) {
            while ($imagen = mysqli_fetch_assoc($resultado_imagenes)) {
                $rutaImagen = '../uploads/' . htmlspecialchars($imagen['ruta_imagen']);
                echo "<img src='$rutaImagen' alt='Imagen del departamento' style='width: 100px; height: auto; border-radius: 4px;'>";
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
</style>

<!-- JavaScript para el chat -->
<script>
function abrirChat(event) {
    event.preventDefault();
    document.getElementById("chatContainer").style.display = "flex";

    fetch("api/obtener_mensajes.php?departamento_id=<?php echo $id; ?>")
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
            fetch("api/enviar_mensaje.php", {
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
