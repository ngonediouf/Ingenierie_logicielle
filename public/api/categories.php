<?php
require_once __DIR__ . '/../../models/Categorie.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$categorieModel = new Categorie();
echo json_encode($categorieModel->getAll());
