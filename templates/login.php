<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - HouseForaneo</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Iniciar Sesión en HouseForaneo</h2>
        <form action="../api/login_usuario.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </form>
    </div>
</body>
</html>
