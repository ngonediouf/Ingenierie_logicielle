<?php
/** @var array $articles */
/** @var array $categories */
/** @var int|null $categorieId */
?>
<main>
    <?php if ($categorieId): ?>
        <?php
            $catActuelle = null;
            foreach ($categories as $cat) {
                if ((int) $cat['id'] === $categorieId) {
                    $catActuelle = $cat;
                    break;
                }
            }
        ?>
        <h2>Catégorie : <?= htmlspecialchars($catActuelle['libelle'] ?? '') ?></h2>
    <?php else: ?>
        <h2>Tous les articles</h2>
    <?php endif; ?>

    <?php if (empty($articles)): ?>
        <p class="empty">Aucun article pour le moment.</p>
    <?php else: ?>
        <?php foreach ($articles as $art): ?>
            <div class="article-card">
                <h3>
                    <a href="index.php?controller=article&action=show&id=<?= $art['id'] ?>">
                        <?= htmlspecialchars($art['titre']) ?>
                    </a>
                </h3>
                <p><?= extrait($art['contenu']) ?></p>
                <div class="article-meta">
                    <?= htmlspecialchars($art['categorie_libelle']) ?> &middot; <?= htmlspecialchars($art['dateCreation']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>
