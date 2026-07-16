<?php
require_once __DIR__ . '/../../models/Article.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$articleModel = new Article();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $article = $articleModel->getById((int) $_GET['id']);
            if (!$article) {
                http_response_code(404);
                echo json_encode(['error' => 'Article introuvable']);
                exit;
            }
            echo json_encode($article);
            exit;
        }

        if (isset($_GET['categorie'])) {
            echo json_encode($articleModel->getByCategorie((int) $_GET['categorie']));
            exit;
        }

        echo json_encode($articleModel->getAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['titre']) || empty($data['contenu']) || empty($data['categorie'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Champs requis : titre, contenu, categorie']);
            exit;
        }

        $id = $articleModel->create($data['titre'], $data['contenu'], (int) $data['categorie']);
        http_response_code(201);
        echo json_encode(['id' => $id, 'message' => 'Article créé']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($_GET['id']) || empty($data['titre']) || empty($data['contenu']) || empty($data['categorie'])) {
            http_response_code(400);
            echo json_encode(['error' => 'id (query) et titre, contenu, categorie (body) requis']);
            exit;
        }

        $articleModel->update((int) $_GET['id'], $data['titre'], $data['contenu'], (int) $data['categorie']);
        echo json_encode(['message' => 'Article mis à jour']);
        break;

    case 'DELETE':
        if (empty($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètre id requis']);
            exit;
        }
        $articleModel->delete((int) $_GET['id']);
        echo json_encode(['message' => 'Article supprimé']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
}
