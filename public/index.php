<?php
require_once __DIR__ . '/../config/config.php';

// Lecture du contrôleur et de l'action demandés dans l'URL
// Ex: index.php?controller=article&action=show&id=3
$controllerName = $_GET['controller'] ?? 'article';
$action = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Page introuvable.');
}

require_once $controllerFile;

if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
    http_response_code(404);
    die('Page introuvable.');
}

$controller = new $controllerClass();
$controller->$action();