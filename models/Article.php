<?php
require_once __DIR__ . '/../config/config.php';

class Article
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT a.*, c.libelle AS categorie_libelle
                FROM Article a
                JOIN Categorie c ON c.id = a.categorie
                ORDER BY a.dateCreation DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategorie(int $categorieId): array
    {
        $sql = "SELECT a.*, c.libelle AS categorie_libelle
                FROM Article a
                JOIN Categorie c ON c.id = a.categorie
                WHERE a.categorie = ?
                ORDER BY a.dateCreation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categorieId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT a.*, c.libelle AS categorie_libelle
                FROM Article a
                JOIN Categorie c ON c.id = a.categorie
                WHERE a.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $titre, string $contenu, int $categorieId): string
    {
        $sql = "INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$titre, $contenu, $categorieId]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $id, string $titre, string $contenu, int $categorieId): bool
    {
        $sql = "UPDATE Article
                SET titre = ?, contenu = ?, categorie = ?, dateModification = NOW()
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $contenu, $categorieId, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM Article WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
