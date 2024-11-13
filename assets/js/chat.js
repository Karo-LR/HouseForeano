document.getElementById("chatForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const mensaje = document.getElementById("mensaje").value;
    const departamento_id = document.querySelector('input[name="departamento_id"]').value;

    fetch("enviar_mensaje.php", {
        method: "POST",
        body: new URLSearchParams({
            mensaje: mensaje,
            departamento_id: departamento_id
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarMensajes(departamento_id);
            document.getElementById("mensaje").value = '';
        } else {
            alert("Error al enviar el mensaje.");
        }
    });
});

function cargarMensajes(departamento_id) {
    fetch("obtener_mensajes.php?departamento_id=" + departamento_id)
    .then(response => response.json())
    .then(data => {
        const chatBox = document.getElementById("chatBox");
        chatBox.innerHTML = "";
        data.mensajes.forEach(msg => {
            const p = document.createElement("p");
            p.textContent = msg.usuario + ": " + msg.texto;
            chatBox.appendChild(p);
        });
    });
}

// Cargar mensajes al iniciar
const departamento_id = document.querySelector('input[name="departamento_id"]').value;
cargarMensajes(departamento_id);

// Actualizar chat cada 5 segundos
setInterval(() => cargarMensajes(departamento_id), 5000);
