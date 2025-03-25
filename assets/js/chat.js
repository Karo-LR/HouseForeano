document.getElementById("enviarMensajeBtn").addEventListener("click", function() {
    const toUserId = document.getElementById("toUserId").value;
    const propertyId = document.getElementById("propertyId").value;
    const message = document.getElementById("messageInput").value;

    fetch("api/enviar_mensaje.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            to_user_id: toUserId,
            property_id: propertyId,
            message: message
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        // Aquí puedes actualizar la interfaz del chat
    })
    .catch(error => console.error("Error:", error));
});
