<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

echo "Sesión cerrada. Redireccionando...";

// Redireccionar al usuario a la página de inicio
header("Location: ../index.php");
exit();
?>
