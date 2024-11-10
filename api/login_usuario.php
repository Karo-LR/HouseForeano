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
            $_SESSION['usuario'] = $user['nombre']; // Opcional: guardar el nombre del usuario
            $_SESSION['usuario_id'] = $user['id'];  // Usar 'usuario_id' para que coincida con agregar_departamento.php

            // Redirigir a la página principal o dashboard
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
