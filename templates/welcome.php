<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php?action=login");
    exit();
}

$userName = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a HouseForaneo</title>                                                                                          
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0E2C40, #348F50);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .welcome-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            text-align: center;
        }

        .welcome-message h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .welcome-message p {
            color: #555;
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-finalize {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s;
        }

        .btn-finalize:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-message">
            <h1>Bienvenido, <?php echo htmlspecialchars($userName); ?>!</h1>
            <p>¡Gracias por registrarte en HouseForaneo! Estamos felices de ayudarte a encontrar el mejor lugar para tu estancia mientras estudias.</p>
            <p>Bienvenidos a HouseForaneo, la plataforma diseñada especialmente para estudiantes que necesitan un hogar temporal cerca de su universidad. Sabemos lo desafiante que puede ser encontrar un lugar seguro, cómodo y accesible. Aquí podrás explorar opciones de renta y encontrar el espacio que mejor se adapte a tus necesidades y presupuesto.</p>

            <form action="../index.php" method="get">
                <button type="submit" class="btn-finalize">Finalizar</button>
            </form>
        </div>
    </div>
</body>
</html>
