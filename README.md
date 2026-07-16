# Polytech Actu (mglsi_news)

## Installation

1. Créer la base de données en important le script SQL fourni :
   ```
   mysql -u root -p < mglsi_news.sql
   ```
2. Placer le dossier `actu-app` dans le répertoire servi par votre serveur
   (ex: `htdocs/` pour XAMPP, ou `www/` pour WAMP) :
   ```
   htdocs/actu-app/
   ```
3. Vérifier les identifiants dans `config.php` (par défaut ceux du script SQL :
   utilisateur `mglsi_user`, mot de passe `passer`, base `mglsi_news`).
4. Démarrer Apache + MySQL, puis ouvrir :
   ```
   http://localhost/actu-app/
   ```

## Structure

```
actu-app/
├── config.php          # Connexion PDO à la base
├── index.php           # Page principale (menu + liste des articles)
├── style.css            # Mise en forme (proche de la maquette)
└── api/
    ├── articles.php     # GET/POST/PUT/DELETE sur les articles (JSON)
    └── categories.php   # GET des catégories (JSON)
```

## Page web (index.php)

- Menu "Accueil" + une entrée par catégorie (généré dynamiquement depuis la table `Categorie`).
- Clic sur une catégorie → filtre les articles via `?categorie=ID`.
- Chaque article affiche titre, extrait du contenu et date.

## API REST (dossier api/)

- `GET api/articles.php` → tous les articles
- `GET api/articles.php?categorie=1` → articles d'une catégorie
- `GET api/articles.php?id=3` → un article précis
- `POST api/articles.php` (body JSON: titre, contenu, categorie) → créer un article
- `PUT api/articles.php?id=3` (body JSON: titre, contenu, categorie) → modifier
- `DELETE api/articles.php?id=3` → supprimer
- `GET api/categories.php` → liste des catégories

## Test rapide de l'API avec curl

```bash
curl http://localhost/actu-app/api/articles.php
curl http://localhost/actu-app/api/articles.php?categorie=1
curl -X POST http://localhost/actu-app/api/articles.php \
  -H "Content-Type: application/json" \
  -d '{"titre":"Test","contenu":"Contenu de test","categorie":2}'
```
