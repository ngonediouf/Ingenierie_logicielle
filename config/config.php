<?php
// Identifiants de connexion à la base de données.
// Avec XAMPP par défaut : utilisateur "root", mot de passe vide.
define('DB_HOST', 'localhost');
define('DB_NAME', 'mglsi_news');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Retourne une connexion PDO unique (ouverte une seule fois).
 */
function getConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    return $pdo;
}

/**
 * Tronque un texte et échappe le HTML, pour l'affichage des extraits d'articles.
 */
function extrait(string $texte, int $longueur = 260): string
{
    $texte = trim($texte);
    if (mb_strlen($texte) <= $longueur) {
        return htmlspecialchars($texte);
    }
    return htmlspecialchars(mb_substr($texte, 0, $longueur)) . '...';
}
