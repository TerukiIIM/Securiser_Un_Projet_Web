# Rendu Sécuriser Un Projet Web

## Contributeur

> Jérôme ZHAO ([TerukiIIM](https://github.com/TerukiIIM))

## Projet de Blog Sécurisé

Ce projet est un blog sécurisé développé en PHP. Il permet aux utilisateurs de s'inscrire, de se connecter, de créer, modifier et supprimer des articles. Les administrateurs ont des privilèges supplémentaires pour gérer les articles.

## Fonctionnalités

- **Inscription et Connexion** : Les utilisateurs peuvent s'inscrire et se connecter pour accéder aux fonctionnalités du blog.
- **Création d'Articles** : Les utilisateurs connectés peuvent créer de nouveaux articles.
- **Modification d'Articles** : Les utilisateurs peuvent modifier leurs propres articles. Les administrateurs peuvent modifier tous les articles.
- **Suppression d'Articles** : Les utilisateurs peuvent supprimer leurs propres articles. Les administrateurs peuvent supprimer tous les articles.
- **Déconnexion** : Les utilisateurs peuvent se déconnecter de leur compte.

## Sécurité

Le projet implémente plusieurs mesures de sécurité pour protéger les données des utilisateurs et prévenir les attaques courantes :

- **Protection contre les attaques CSRF (Cross-Site Request Forgery)** : Utilisation de tokens CSRF pour protéger les formulaires.
- **Protection contre les attaques XSS (Cross-Site Scripting)** : Utilisation de `htmlspecialchars` pour échapper les données avant de les afficher.
- **Protection contre les injections SQL** : Utilisation de requêtes préparées avec des paramètres liés.
- **Validation et Filtrage des Données** : Validation et filtrage des données d'entrée pour s'assurer qu'elles sont correctes.
- **Contrôle d'Accès** : Vérification des autorisations des utilisateurs avant d'effectuer des actions sensibles.

## Structure du Projet

Le projet est structuré en plusieurs fichiers PHP :

- `index.php` : Page d'accueil pour l'inscription et la connexion.
- `login.php` : Gestion de la connexion des utilisateurs.
- `register.php` : Gestion de l'inscription des utilisateurs.
- `page.php` : Page principale du blog où les utilisateurs peuvent voir et gérer les articles.
- `traitement.php` : Gestion de la création des articles.
- `edit.php` : Gestion de la modification des articles.
- `delete.php` : Gestion de la suppression des articles.
- `logout.php` : Gestion de la déconnexion des utilisateurs.
- `database.php` : Connexion à la base de données.

## Installation

1. Clonez le dépôt sur votre machine locale.
2. Configurez votre serveur web pour pointer vers le répertoire du projet.
3. Créez une base de données MySQL et importez le fichier `securite.sql` pour créer les tables nécessaires.
4. Configurez les informations de connexion à la base de données dans `database.php`.
5. Lancez le serveur web et accédez à l'application via votre navigateur.

## Utilisation

1. Accédez à la page d'accueil (`index.php`) pour vous inscrire ou vous connecter.
2. Une fois connecté, vous serez redirigé vers la page principale (`page.php`) où vous pourrez créer, modifier et supprimer des articles.
3. Utilisez le bouton de déconnexion en haut à droite pour vous déconnecter.