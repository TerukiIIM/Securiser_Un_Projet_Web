<?php
    try {
        $connexion = new PDO("mysql:host=localhost;dbname=securite", "root", "");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die("Erreur SQL : " . $e->getMessage());
    }

    // Récupérer tous les posts de la base de données avec le nom de l'utilisateur
    $sql = "SELECT post.id, post.title, post.content, post.user_id, user.username 
            FROM post 
            JOIN user ON post.user_id = user.id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>