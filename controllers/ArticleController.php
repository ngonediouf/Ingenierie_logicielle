<?php
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Categorie.php';

class ArticleController
{
    private Article $articleModel;
    private Categorie $categorieModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categorieModel = new Categorie();
    }

    /**
     * Page d'accueil : liste des articles, filtrable par catégorie (?categorie=ID)
     */
    public function index(): void
    {
        $categories = $this->categorieModel->getAll();

        $categorieId = isset($_GET['categorie']) && $_GET['categorie'] !== ''
            ? (int) $_GET['categorie']
            : null;

        $articles = $categorieId
            ? $this->articleModel->getByCategorie($categorieId)
            : $this->articleModel->getAll();

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/articles/liste.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Détail d'un article : ?controller=article&action=show&id=3
     */
    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $article = $this->articleModel->getById($id);

        if (!$article) {
            http_response_code(404);
            echo "Article introuvable.";
            return;
        }

        $categories = $this->categorieModel->getAll();

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/articles/show.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
