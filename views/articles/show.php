<?php
/** @var array $article */
?>
<main>
    <p><a href="index.php">&larr; Retour à la liste</a></p>

    <div class="article-card">
        <h3><?= htmlspecialchars($article['titre']) ?></h3>
        <div class="article-meta">
            <?= htmlspecialchars($article['categorie_libelle']) ?> &middot;
            Publié le <?= htmlspecialchars($article['dateCreation']) ?>
            <?php if ($article['dateModification'] !== $article['dateCreation']): ?>
                (modifié le <?= htmlspecialchars($article['dateModification']) ?>)
            <?php endif; ?>
        </div>
        <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
    </div>
</main>
