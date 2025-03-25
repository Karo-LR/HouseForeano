<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - HouseForaneo</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Cambiar Contraseña</h2>
        <form action="../api/cambiar_password_usuario.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password_nuevo">Nueva Contraseña:</label>
            <input type="password" id="password_nuevo" name="password_nuevo" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Cambiar Contraseña</button>
        </form>
    </div>
</body>
</html>