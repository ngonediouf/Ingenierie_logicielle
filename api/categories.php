<?php
require __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$stmt = $pdo->query("SELECT id, libelle FROM Categorie ORDER BY id");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
