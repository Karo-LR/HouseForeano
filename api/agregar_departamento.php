<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// Verifica que todas las variables necesarias estén en $_POST
if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['ciudad'], $_POST['estado'], $_POST['direccion'], $_POST['precio'], $_POST['tipo_propiedad'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $direccion = $_POST['direccion'];
    $precio = (float) $_POST['precio'];
    $tipo_propiedad = $_POST['tipo_propiedad'];

    // Preparar la consulta para insertar un nuevo departamento
    $stmt = $conn->prepare("INSERT INTO departamentos (titulo, descripcion, ciudad, estado, direccion, precio, tipo_propiedad, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit();
    }

    $stmt->bind_param("sssssdsi", $titulo, $descripcion, $ciudad, $estado, $direccion, $precio, $tipo_propiedad, $id_usuario);

    if ($stmt->execute()) {
        $departamento_id = $stmt->insert_id;  // Obtener el ID del departamento recién agregado

        // Procesar las imágenes
        if (!empty($_FILES['imagenes']['name'][0])) {
            $imagenes = $_FILES['imagenes'];
            $total_imagenes = count($imagenes['name']);

            // Directorio donde se guardarán las imágenes
            $upload_dir = "../assets/img/";

            // Verifica si el directorio existe, si no, lo crea
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Procesa cada imagen
            for ($i = 0; $i < $total_imagenes; $i++) {
                $imagen_nombre = basename($imagenes['name'][$i]);
                $imagen_ruta = $upload_dir . $imagen_nombre;
                $imagen_tipo = pathinfo($imagen_ruta, PATHINFO_EXTENSION);

                // Validar tipo de archivo (opcional, puedes ajustar esto según tus necesidades)
                $formatos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array(strtolower($imagen_tipo), $formatos_permitidos)) {
                    // Mueve la imagen al directorio de destino
                    if (move_uploaded_file($imagenes['tmp_name'][$i], $imagen_ruta)) {
                        // Guarda la ruta de la imagen en la base de datos
                        $stmt_img = $conn->prepare("INSERT INTO imagenes_departamento (departamento_id, ruta_imagen) VALUES (?, ?)");
                        if ($stmt_img) {
                            $stmt_img->bind_param("is", $departamento_id, $imagen_nombre);
                            $stmt_img->execute();
                            $stmt_img->close();
                        }
                    } else {
                        echo "Error al subir la imagen: " . $imagen_nombre;
                    }
                } else {
                    echo "Formato de imagen no permitido: " . $imagen_nombre;
                }
            }
        }

        echo "Departamento agregado exitosamente.";
    } else {
        echo "Error al agregar el departamento: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Faltan datos necesarios para agregar el departamento.";
}

$conn->close();
?>
