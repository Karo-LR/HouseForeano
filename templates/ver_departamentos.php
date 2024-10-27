<!DOCTYPE html>
<html>
<head>
    <title>Departamentos Disponibles</title>
</head>
<body>
    <h1>Departamentos en Renta</h1>
    <div id="departamentos"></div>

    <script>
        fetch('../api/obtener_departamentos.php')
            .then(response => response.json())
            .then(data => {
                const contenedor = document.getElementById('departamentos');
                data.departamentos.forEach(dpto => {
                    contenedor.innerHTML += `<p>${dpto.direccion} - ${dpto.precio}</p>`;
                });
            });
    </script>
</body>
</html>
