<?php
require_once '../config/db.php';
session_start(); // Iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estado = $_POST['estado'];
    $direccion = $_POST['direccion'];
    $tipo_propiedad = $_POST['tipo_propiedad'];
    $precio = $_POST['precio'];

    // Verifica si 'usuario_id' existe en $_SESSION antes de usarlo
    if (!isset($_SESSION['id_usuario'])) {
        echo "Error: Usuario no autenticado.";
        exit();
    }

    $usuario_id = $_SESSION['usuario_id']; // Asegúrate de que el usuario está autenticado

    // Inserta el departamento
    $query = "INSERT INTO departamentos (usuario_id, estado, direccion, tipo_propiedad, precio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    // Verifica si la consulta fue preparada correctamente
    if ($stmt === false) {
        echo "Error en la consulta: " . $conn->error;
        exit();
    }

    $stmt->bind_param("isssd", $usuario_id, $estado, $direccion, $tipo_propiedad, $precio);

    if ($stmt->execute()) {
        $departamento_id = $stmt->insert_id;

        // Procesa cada imagen
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $nombre_imagen = $_FILES['imagenes']['name'][$key];
            $ruta_destino = "../assets/img/" . $nombre_imagen;

            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $query_img = "INSERT INTO imagenes_departamento (departamento_id, ruta) VALUES (?, ?)";
                $stmt_img = $conn->prepare($query_img);

                // Verifica si la consulta para la imagen fue preparada correctamente
                if ($stmt_img === false) {
                    echo "Error en la consulta de la imagen: " . $conn->error;
                    exit();
                }

                $stmt_img->bind_param("is", $departamento_id, $ruta_destino);
                $stmt_img->execute();
            }
        }
        echo "Departamento agregado exitosamente.";
    } else {
        echo "Error al agregar el departamento.";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../templates/subir_departamento.php");
    exit();
}
?>
