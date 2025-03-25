<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Corrección aquí: sintaxis correcta para define()
define('DB_NAME', 'houseforaneo'); // Asegúrate de poner el nombre correcto de tu base de datos

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function executeQuery($query, $params = []) {
    global $conn;
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error in query preparation: " . $conn->error);
    }

    if ($params) {
        $types = '';
        foreach ($params as $param) {
            $types .= is_int($param) ? 'i' : (is_double($param) ? 'd' : 's');
        }

        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}
?>