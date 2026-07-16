<?php $categories ??= []; ?>
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
    <a href="index.php" class="<?= empty($_GET['categorie']) ? 'active' : '' ?>">Accueil</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?categorie=<?= $cat['id'] ?>"
           class="<?= (isset($_GET['categorie']) && (int) $_GET['categorie'] === (int) $cat['id']) ? 'active-pink' : '' ?>">
            <?= htmlspecialchars($cat['libelle']) ?>
        </a>
    <?php endforeach; ?>
</nav>
