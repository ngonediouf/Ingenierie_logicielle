<?php
require __DIR__ . '/config.php';

// Récupère toutes les catégories pour construire le menu
$categories = $pdo->query("SELECT id, libelle FROM Categorie ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

// Catégorie sélectionnée (via ?categorie=ID), sinon toutes
$categorieId = isset($_GET['categorie']) && $_GET['categorie'] !== ''
    ? (int) $_GET['categorie']
    : null;

if ($categorieId) {
    $stmt = $pdo->prepare(
        "SELECT a.*, c.libelle AS categorie_libelle
         FROM Article a
         JOIN Categorie c ON c.id = a.categorie
         WHERE a.categorie = ?
         ORDER BY a.dateCreation DESC"
    );
    $stmt->execute([$categorieId]);
} else {
    $stmt = $pdo->query(
        "SELECT a.*, c.libelle AS categorie_libelle
         FROM Article a
         JOIN Categorie c ON c.id = a.categorie
         ORDER BY a.dateCreation DESC"
    );
}
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

function extrait(string $texte, int $longueur = 260): string
{
    $texte = trim($texte);
    if (mb_strlen($texte) <= $longueur) {
        return htmlspecialchars($texte);
    }
    return htmlspecialchars(mb_substr($texte, 0, $longueur)) . '...';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Polytech Actu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <h1>Actualités Polytechniciennes</h1>
</header>

<nav class="main-nav">
    <a href="index.php" class="<?= $categorieId === null ? 'active' : '' ?>">Accueil</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?categorie=<?= $cat['id'] ?>"
           class="<?= $categorieId === (int)$cat['id'] ? 'active-pink' : '' ?>">
            <?= htmlspecialchars($cat['libelle']) ?>
        </a>
    <?php endforeach; ?>
</nav>

<main>
    <h2>Les dernières actualités</h2>

    <?php if (empty($articles)): ?>
        <p class="empty">Aucun article dans cette catégorie pour le moment.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <article class="article-card">
                <h3><?= htmlspecialchars($article['titre']) ?></h3>
                <p><?= extrait($article['contenu']) ?></p>
                <div class="article-meta">
                    <?= htmlspecialchars($article['categorie_libelle']) ?>
                    &middot;
                    <?= date('d/m/Y', strtotime($article['dateCreation'])) ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>
