// modo_oscuro.php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoModo = $_POST['modo_oscuro']; // 1 para oscuro, 0 para claro
    $userId = $_SESSION['user_id'];

    $query = "UPDATE usuarios SET modo_oscuro = ? WHERE id = ?";
    $params = ['ii', $nuevoModo, $userId];
    $stmt = executeQuery($query, $params);

    echo $stmt ? "Modo actualizado con éxito." : "Error al actualizar el modo.";
}
?>

<!-- JavaScript para alternar entre modo oscuro y claro -->
<script>
document.querySelector("#modoOscuro").addEventListener("click", function() {
    document.body.classList.toggle("modo-oscuro");
    // Aquí puedes agregar una petición AJAX para enviar el valor de modo oscuro/claro al servidor.
});
</script>
