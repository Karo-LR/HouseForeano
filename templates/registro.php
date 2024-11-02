<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - HouseForaneo</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Registrarse en HouseForaneo</h2>
        <form action="../api/registrar_usuario.php" method="POST" onsubmit="return validateForm()">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label>Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <span class="error-message" id="error-message" style="display:none; color:red;">Las contraseñas no coinciden</span><br>

            <label for="tipo_usuario">Tipo de Usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario">
                <option value="arrendatario">Arrendatario</option>
                <option value="inquilino">Inquilino</option>
            </select><br>

            <button type="submit">Registrarse</button>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </form>
    </div>

    <script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const errorMessage = document.getElementById("error-message");

            if (password !== confirmPassword) {
                errorMessage.style.display = "inline";
                return false; // Evita que el formulario se envíe
            } else {
                errorMessage.style.display = "none";
                return true;
            }
        }
    </script>
</body>
</html>
