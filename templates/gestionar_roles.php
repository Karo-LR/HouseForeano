<?php
session_start();
include_once '../config/db.php';

// Verificar rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') {
    echo "Acceso denegado.";
    exit;
}

// Funciones para gestionar roles y permisos (ejemplos)
function obtenerUsuarios($conn) {
    $stmt = $conn->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $result = $stmt->get_result(); // Obtener el resultado de la consulta
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerRoles($conn) {
    $stmt = $conn->prepare("SELECT * FROM roles");
    $stmt->execute();
    $result = $stmt->get_result(); // Obtener el resultado de la consulta
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>