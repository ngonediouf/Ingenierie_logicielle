# Polytech Actu — MVC classique

## Architecture

```
actu-app-mvc/
├── config/
│   └── config.php            # Identifiants DB + connexion PDO + fonctions utilitaires
├── models/                   # MODELE : accès aux données uniquement
│   ├── Article.php
│   └── Categorie.php
├── controllers/               # CONTROLEUR : logique métier, aucun SQL ni HTML
│   └── ArticleController.php
├── views/                      # VUE : uniquement de l'affichage (HTML)
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   └── articles/
│       ├── index.php
│       └── show.php
├── public/                     # Dossier accessible au navigateur
│   ├── index.php               # Front controller : point d'entrée + routage
│   ├── style.css
│   └── api/
│       ├── articles.php
│       └── categories.php
└── mglsi_news.sql
```

C'est le MVC classique à 3 couches (Modèle / Vue / Contrôleur), sans dossier
technique supplémentaire :

- `config/config.php` regroupe la connexion à la base et les petites
  fonctions utilitaires (plus besoin d'un dossier `core/` séparé).
- `public/index.php` fait à la fois office de point d'entrée **et** de
  routeur : il lit `?controller=` et `?action=` dans l'URL, puis appelle
  directement la bonne méthode du bon contrôleur (pas de classe `Router`
  séparée).

## Principe

1. Le navigateur appelle `public/index.php` (seul fichier public).
2. `index.php` regarde `$_GET['controller']` et `$_GET['action']`
   (par défaut : `article` / `index`).
3. Il inclut le fichier du contrôleur correspondant et appelle la méthode.
4. Le **Contrôleur** appelle les **Modèles** pour récupérer les données,
   puis inclut la **Vue** pour l'affichage.
5. Les **Modèles** sont les seuls fichiers à contenir des requêtes SQL.
6. Les **Vues** ne contiennent que du HTML + les variables déjà préparées.

## Installation (XAMPP)

1. Copier tout le dossier `actu-app-mvc/` dans `htdocs/`.
2. Importer `mglsi_news.sql` dans phpMyAdmin.
3. Vérifier `config/config.php` (par défaut : `root` / mot de passe vide).
4. Démarrer Apache + MySQL.
5. Ouvrir : `http://localhost/actu-app-mvc/public/`

## URLs disponibles

| URL | Effet |
|---|---|
| `public/` | Liste de tous les articles |
| `public/?categorie=1` | Articles de la catégorie 1 (Sport) |
| `public/?controller=article&action=show&id=2` | Détail de l'article 2 |
| `public/api/articles.php` | Articles en JSON |
| `public/api/categories.php` | Catégories en JSON |
