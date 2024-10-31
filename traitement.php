<?php
    session_start();
    include 'database.php';

    // On vérifie le CSRF token avant quoi que ce soit
    if (isset($_POST["token"]) && $_POST["token"] != $_SESSION["csrf_article_add"]) {
        $_SESSION['message'] = "CSRF invalide";
        ("Location: page.php");
        exit();
    }

    // Supprime le token en session pour qu'il soit régénéré
    unset($_SESSION["csrf_article_add"]);

    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "Vous devez être connecté pour ajouter un article";
        header("Location: page.php");
        exit();
    }

    // Initialisation des variables
    $title = $content = "";
    $errors = [];

    // Vérification du titre
    if (isset($_POST["title"]) && !empty($_POST["title"])) {
        $title = htmlspecialchars($_POST["title"]);
    } else {
        $errors[] = "Le titre est obligatoire";
    }

    // Vérification du contenu
    if (isset($_POST["content"]) && !empty($_POST["content"])) {
        $content = htmlspecialchars($_POST["content"]);
    } else {
        $errors[] = "Le contenu est obligatoire";
    }

    // Si des erreurs sont présentes, on les stocke dans la session et on redirige
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: page.php");
        exit();
    }

    // Insertion des données dans la base de données
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO post (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    if ($stmt->execute([$title, $content, $user_id])) {
        $_SESSION['message'] = "Article ajouté avec succès";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout de l'article";
    }

    header("Location: page.php");
    exit();
?>