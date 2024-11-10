<?php
session_start();
require_once '../config/db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../templates/login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$direccion = $_POST['direccion'];
$precio = $_POST['precio'];
$tipo_propiedad = $_POST['tipo_propiedad'];

// Insertar datos del departamento en la base de datos
$query = "INSERT INTO departamentos (id_usuario, titulo, descripcion, ciudad, estado, direccion, precio, tipo_propiedad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isssssis", $id_usuario, $titulo, $descripcion, $ciudad, $estado, $direccion, $precio, $tipo_propiedad);
$stmt->execute();

// Obtener el ID del departamento insertado
$departamento_id = $stmt->insert_id;

// Verificar si se subieron imágenes
if (isset($_FILES['imagenes']) && $_FILES['imagenes']['error'][0] === UPLOAD_ERR_OK) {
    // Directorio donde se guardarán las imágenes
    $directorio = "../uploads/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Procesar cada imagen
    foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
        $nombre_imagen = $_FILES['imagenes']['name'][$key];
        $ruta_imagen = $directorio . uniqid() . "_" . basename($nombre_imagen);

        // Mover la imagen al directorio de destino
        if (move_uploaded_file($tmp_name, $ruta_imagen)) {
            // Guardar la ruta de la imagen en la tabla `imagenes_departamento`
            $query_imagen = "INSERT INTO imagenes_departamento (departamento_id, ruta_imagen) VALUES (?, ?)";
            $stmt_imagen = $conn->prepare($query_imagen);
            $stmt_imagen->bind_param("is", $departamento_id, $ruta_imagen);
            $stmt_imagen->execute();
        }
    }
}

// Cerrar conexiones
$stmt->close();
$conn->close();

// Redirigir al usuario a la página de "Mis Departamentos"
header("Location: ../templates/mis_departamentos.php");
exit();
?>
