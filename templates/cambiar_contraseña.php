// cambiar_contrasena.php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contrasenaActual = $_POST['contrasena_actual'];
    $nuevaContrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_BCRYPT);
    $userId = $_SESSION['user_id'];

    // Verificar la contraseña actual
    $query = "SELECT contrasena FROM usuarios WHERE id = ?";
    $params = ['i', $userId];
    $stmt = executeQuery($query, $params);
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($contrasenaActual, $hashedPassword)) {
        // Actualizar con la nueva contraseña
        $query = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
        $params = ['si', $nuevaContrasena, $userId];
        $stmt = executeQuery($query, $params);

        echo $stmt ? "Contraseña cambiada con éxito." : "Error al cambiar la contraseña.";
    } else {
        echo "La contraseña actual no es correcta.";
    }
}
?>

<!-- Formulario HTML para cambiar contraseña -->
<form action="cambiar_contrasena.php" method="post">
    Contraseña Actual: <input type="password" name="contrasena_actual" required><br>
    Nueva Contraseña: <input type="password" name="nueva_contrasena" required><br>
    <button type="submit">Cambiar Contraseña</button>
</form>
