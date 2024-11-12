<?php
session_start();
require_once '../config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
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
<body>

<h1><?php echo htmlspecialchars($departamento['titulo']); ?></h1>
<p><?php echo nl2br(htmlspecialchars($departamento['descripcion'])); ?></p>
<p>Dirección: <?php echo htmlspecialchars($departamento['direccion']); ?></p>
<p>Precio: $<?php echo number_format($departamento['precio'], 2); ?></p>

<div id="map" style="width:100%; height:400px;"></div>
<script>
    function initMap() {
        var ubicacion = { lat: <?php echo $departamento['latitud']; ?>, lng: <?php echo $departamento['longitud']; ?> };
        var map = new google.maps.Map(document.getElementById('map'), { zoom: 15, center: ubicacion });
        new google.maps.Marker({ position: ubicacion, map: map });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

<div class="galeria">
    <?php
    $query_imagenes = "SELECT * FROM imagenes_departamento WHERE departamento_id = $id";
    $resultado_imagenes = mysqli_query($conn, $query_imagenes);

    if ($resultado_imagenes) {
        while ($imagen = mysqli_fetch_assoc($resultado_imagenes)) {
            $rutaImagen = '../uploads/' . htmlspecialchars($imagen['ruta_imagen']);
            echo "<img src='$rutaImagen' alt='Imagen del departamento' class='departamento-imagen'>";
        }
    } else {
        echo "<p>No hay imágenes disponibles para este departamento.</p>";
    }
    ?>
</div>

<a href="#" onclick="abrirChat(event)">Contactar al Rendatario</a>

<div id="chatContainer" class="chat-hidden">
    <div class="chat-header">
        <h3>Chat con el Rendatario</h3>
        <button onclick="cerrarChat()">X</button>
    </div>
    <div id="chatMessages" class="chat-messages"></div>
    <input type="text" id="chatInput" placeholder="Escribe un mensaje..." onkeypress="enviarMensaje(event)">
</div>

<script>
// Función para abrir el chat
function abrirChat(event) {
    event.preventDefault();
    document.getElementById("chatContainer").style.display = "flex";
    loadMessages();
}

// Función para cerrar el chat
function cerrarChat() {
    document.getElementById("chatContainer").style.display = "none";
}

// Función para cargar mensajes
function loadMessages() {
    fetch('api/obtener_mensajes.php?id_departamento=<?php echo $id; ?>&id_receptor=<?php echo $departamento['id_usuario']; ?>')
        .then(response => response.json())
        .then(data => {
            const messagesDiv = document.getElementById('chatMessages');
            messagesDiv.innerHTML = data.map(msg => `<p><strong>${msg.sender}:</strong> ${msg.mensaje}</p>`).join('');
        });
}

// Enviar mensaje al presionar "Enter"
function enviarMensaje(event) {
    if (event.key === 'Enter') {
        const mensaje = document.getElementById("chatInput").value.trim();
        if (mensaje !== "") {
            fetch('api/enviar_mensaje.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_departamento: <?php echo $id; ?>,
                    id_receptor: <?php echo $departamento['id_usuario']; ?>,
                    mensaje: mensaje
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("chatInput").value = "";
                    loadMessages();
                }
            });
        }
    }
}

// Actualizar mensajes cada 5 segundos
setInterval(loadMessages, 5000);
</script>

<style>
    /* Estilos para la galería de imágenes */
    .galeria {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .departamento-imagen {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }

    /* Estilos del contenedor de chat */
    #chatContainer {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        max-height: 400px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        display: none;
        flex-direction: column;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .chat-header {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .chat-messages {
        padding: 10px;
        height: 300px;
        overflow-y: auto;
    }
    #chatInput {
        width: 100%;
        padding: 10px;
        border-top: 1px solid #ddd;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
</style>

</body>
</html>
