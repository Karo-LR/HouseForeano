<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - HouseForaneo</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Recuperar Contraseña</h2>
        <form action="../api/recuperar_password_usuario.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar Enlace de Recuperación</button>
        </form>
    </div>
</body>
</html>