<?php
require_once __DIR__ . '/../config/config.php';

class Categorie
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function getAll(): array
    {
        return $this->pdo
            ->query("SELECT id, libelle FROM Categorie ORDER BY id")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT id, libelle FROM Categorie WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
