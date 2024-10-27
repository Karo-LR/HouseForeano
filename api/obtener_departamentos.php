<?php
require '../config/db.php';

$stmt = $pdo->query("SELECT * FROM departamentos");
$departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => 'success', 'departamentos' => $departamentos]);
?>
