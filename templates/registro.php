<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <form action="../api/registrar_usuario.php" method="POST">
        <label>Nombre:</label><input type="text" name="nombre" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Contraseña:</label><input type="password" name="password" required><br>
        <label>Tipo de Usuario:</label>
        <select name="tipo_usuario">
            <option value="arrendatario">Arrendatario</option>
            <option value="inquilino">Inquilino</option>
        </select><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
