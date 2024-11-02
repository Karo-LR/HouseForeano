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
</head>
<body>
    <div class="welcome-message">
        <h1>Bienvenido, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p>¡Gracias por registrarte en HouseForaneo! Estamos felices de ayudarte a encontrar el mejor lugar para tu estancia mientras estudias.</p>
        <p>Bienvenidos a HouseForaneo, la plataforma diseñada especialmente para estudiantes que necesitan un hogar temporal cerca de su universidad. Sabemos lo desafiante que puede ser encontrar un lugar seguro, cómodo y accesible. Aquí podrás explorar opciones de renta y encontrar el espacio que mejor se adapte a tus necesidades y presupuesto.</p>

        <form action="../index.php" method="get">
            <button type="submit" class="btn-finalize">Finalizar</button>
        </form>
    </div>
</body>
</html>
