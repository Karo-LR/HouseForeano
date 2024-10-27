<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <form action="../api/login_usuario.php" method="POST">
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Contraseña:</label><input type="password" name="password" required><br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
