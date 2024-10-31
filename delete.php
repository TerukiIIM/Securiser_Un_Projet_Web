<?php
    session_start();
    include 'database.php';

    // On vérifie le CSRF token avant quoi que ce soit
    if (isset($_POST["token"]) && $_POST["token"] != $_SESSION["csrf_article_add"]) {
        die("<p>CSRF invalide</p>");
    }

    // Supprime le token en session pour qu'il soit régénéré
    unset($_SESSION["csrf_article_add"]);

    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        die("<p>Vous devez être connecté pour supprimer un article</p>");
    }

    // Vérifiez si l'utilisateur est admin
    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

    // Récupération de l'ID du post
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    // Vérification de l'existence du post et de l'autorisation de suppression
    $sql = "SELECT user_id FROM post WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        if ($is_admin || $post['user_id'] == $_SESSION['user_id']) {
            // Suppression du post
            $sql = "DELETE FROM post WHERE id = ?";
            $stmt = $connexion->prepare($sql);
            if ($stmt->execute([$post_id])) {
                header("Location: page.php");
                exit();
            } else {
                header("Location: page.php");
                exit();
            }
        } else {
            header("Location: page.php");
            exit();
        }
    } else {
        header("Location: page.php");
        exit();
    }
?>