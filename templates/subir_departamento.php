<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Departamento</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Estilos del contenedor y botones */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200vh;
        }
        .upload-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }
        .upload-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #333333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Función para generar campos de carga de imágenes
        function generarCamposImagenes() {
            // Obtener la cantidad de imágenes seleccionada
            const cantidad = document.getElementById("cantidad_imagenes").value;
            const contenedorImagenes = document.getElementById("imagenesContainer");

            // Limpiar cualquier campo de imagen existente
            contenedorImagenes.innerHTML = "";

            // Generar campos de imagen según la cantidad especificada
            for (let i = 0; i < cantidad; i++) {
                const label = document.createElement("label");
                label.textContent = `Imagen ${i + 1}:`;
                
                const input = document.createElement("input");
                input.type = "file";
                input.name = "imagenes[]";
                input.required = true;

                const div = document.createElement("div");
                div.className = "form-group";
                div.appendChild(label);
                div.appendChild(input);

                contenedorImagenes.appendChild(div);
            }
        }
    </script>
</head>
<body>
    <div class="upload-container">
        <div class="upload-header">Subir un Nuevo Departamento</div>
        <form action="../api/agregar_departamento.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" rows="4" style="width: 100%;" required></textarea>
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" name="estado" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio (MXN/mes):</label>
                <input type="number" name="precio" required>
            </div>
            <div class="form-group">
                <label for="tipo_propiedad">Tipo de propiedad:</label>
                <select name="tipo_propiedad" required>
                    <option value="cuarto">Cuarto</option>
                    <option value="departamento">Departamento</option>
                    <option value="casa">Casa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad_imagenes">¿Cuántas imágenes deseas subir?</label>
                <input type="number" id="cantidad_imagenes" min="1" max="10" onchange="generarCamposImagenes()" required>
            </div>
            <!-- Contenedor donde se generan dinámicamente los campos de imágenes -->
            <div id="imagenesContainer"></div>
            <button type="submit" class="btn-submit">Subir Departamento</button>
        </form>
    </div>
</body>
</html>
