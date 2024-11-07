// acceder_informacion.php
session_start();
require 'conexion.php';

$userId = $_SESSION['user_id'];
$query = "SELECT nombre, email FROM usuarios WHERE id = ?";
$params = ['i', $userId];
$stmt = executeQuery($query, $params);
$stmt->bind_result($nombre, $email);
$stmt->fetch();
?>

<h2>Tu Información</h2>
<p>Nombre: <?php echo htmlspecialchars($nombre); ?></p>
<p>Email: <?php echo htmlspecialchars($email); ?></p>
