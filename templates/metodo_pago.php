// metodo_pago.php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metodo_pago = $_POST['metodo_pago'];
    $userId = $_SESSION['user_id'];

    $query = "UPDATE usuarios SET metodo_pago = ? WHERE id = ?";
    $params = ['si', $metodo_pago, $userId];
    $stmt = executeQuery($query, $params);

    echo $stmt ? "Método de pago actualizado con éxito." : "Error al actualizar el método de pago.";
}
?>

<!-- Formulario HTML para agregar/actualizar método de pago -->
<form action="metodo_pago.php" method="post">
    Método de Pago: <input type="text" name="metodo_pago" required><br>
    <button type="submit">Actualizar Método de Pago</button>
</form>
