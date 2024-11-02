<?php
require '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para buscar el usuario por email
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Establecer variables de sesión para el usuario
            $_SESSION['usuario'] = $user['nombre']; // Usar 'usuario' en lugar de 'nombre' para que coincida con el index.php
            $_SESSION['user_id'] = $user['id']; // Opcional, si deseas usar el ID más adelante

            // Redirigir a la página principal
            header("Location: ../index.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>
                    alert('Contraseña incorrecta');
                    window.location.href = '../templates/login.php';
                  </script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script>
                alert('Usuario no encontrado');
                window.location.href = '../templates/login.php';
              </script>";
    }

    $stmt->close();
} else {
    // Método no permitido
    echo "<script>
            alert('Método no permitido');
            window.location.href = '../templates/login.php';
          </script>";
}
?>
