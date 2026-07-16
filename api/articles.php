<?php
require __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare(
                "SELECT a.*, c.libelle AS categorie_libelle
                 FROM Article a JOIN Categorie c ON c.id = a.categorie
                 WHERE a.id = ?"
            );
            $stmt->execute([(int) $_GET['id']]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$article) {
                http_response_code(404);
                echo json_encode(['error' => 'Article introuvable']);
                exit;
            }
            echo json_encode($article);
            exit;
        }

        if (isset($_GET['categorie'])) {
            $stmt = $pdo->prepare(
                "SELECT a.*, c.libelle AS categorie_libelle
                 FROM Article a JOIN Categorie c ON c.id = a.categorie
                 WHERE a.categorie = ? ORDER BY a.dateCreation DESC"
            );
            $stmt->execute([(int) $_GET['categorie']]);
        } else {
            $stmt = $pdo->query(
                "SELECT a.*, c.libelle AS categorie_libelle
                 FROM Article a JOIN Categorie c ON c.id = a.categorie
                 ORDER BY a.dateCreation DESC"
            );
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['titre']) || empty($data['contenu']) || empty($data['categorie'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Champs requis : titre, contenu, categorie']);
            exit;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)"
        );
        $stmt->execute([$data['titre'], $data['contenu'], (int) $data['categorie']]);

        http_response_code(201);
        echo json_encode(['id' => $pdo->lastInsertId(), 'message' => 'Article créé']);
        break;

    case 'PUT':
        parse_str(file_get_contents('php://input'), $putVars);
        $data = json_decode(file_get_contents('php://input'), true) ?? $putVars;

        if (empty($_GET['id']) || empty($data['titre']) || empty($data['contenu']) || empty($data['categorie'])) {
            http_response_code(400);
            echo json_encode(['error' => 'id (query) et titre, contenu, categorie (body) requis']);
            exit;
        }

        $stmt = $pdo->prepare(
            "UPDATE Article
             SET titre = ?, contenu = ?, categorie = ?, dateModification = NOW()
             WHERE id = ?"
        );
        $stmt->execute([$data['titre'], $data['contenu'], (int) $data['categorie'], (int) $_GET['id']]);

        echo json_encode(['message' => 'Article mis à jour']);
        break;

    case 'DELETE':
        if (empty($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètre id requis']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM Article WHERE id = ?");
        $stmt->execute([(int) $_GET['id']]);
        echo json_encode(['message' => 'Article supprimé']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
}
