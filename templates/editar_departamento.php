<?php
// Inicia la sesión
session_start();
require_once '../config/db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// Verifica si se recibió el ID del departamento
if (!isset($_GET['id'])) {
    echo 'No se especificó ningún departamento para editar';
    exit();
}

$id_departamento = $_GET['id'];

// Consulta para obtener los datos del departamento
$stmt = $conn->prepare("SELECT * FROM departamentos WHERE id_departamento = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_departamento, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si el departamento existe
if ($result->num_rows === 0) {
    echo 'No se encontró el departamento.';
    exit();
}

$departamento = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

    <title>Editar Departamento</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
            overflow-y: scroll; /* Permitir que se vea todo */
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 20px; /* Márgenes para asegurarse de que se vea en pantallas pequeñas */
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .image-preview {
            margin-top: 10px;
        }

        .image-preview img {
            width: 100px;
            height: auto;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-group button {
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-group button:hover {
            background-color: #0056b3;
        }

        .btn-group .cancel {
            background-color: #6c757d;
        }

        .btn-group .cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Editar Departamento</h2>
    <form action="../api/actualizar_departamento.php" method="POST">
    <input type="hidden" name="id_departamento" value="<?= htmlspecialchars($departamento['id_departamento']) ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($departamento['titulo']) ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($departamento['descripcion']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= htmlspecialchars($departamento['ciudad']) ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= htmlspecialchars($departamento['estado']) ?>" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($departamento['direccion']) ?>" required>
        </div>

        <div class="form-group">
            <label for="precio">Precio (MXN/mes)</label>
            <input type="number" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($departamento['precio']) ?>" required>
        </div>

        <div class="form-group">
            <label for="tipo_propiedad">Tipo de Propiedad</label>
            <select class="form-control" id="tipo_propiedad" name="tipo_propiedad">
                <option value="Cuarto" <?= $departamento['tipo_propiedad'] == 'Cuarto' ? 'selected' : '' ?>>Cuarto</option>
                <option value="Apartamento" <?= $departamento['tipo_propiedad'] == 'Apartamento' ? 'selected' : '' ?>>Apartamento</option>
                <option value="Casa" <?= $departamento['tipo_propiedad'] == 'Casa' ? 'selected' : '' ?>>Casa</option>
            </select>
        </div>

        <div class="form-group">
            <label for="imagenes">Imágenes (puedes subir nuevas o mantener las existentes):</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen[]" multiple>
            <small class="form-text text-muted">Imágenes actuales: <?= htmlspecialchars($departamento['imagen']) ?></small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
