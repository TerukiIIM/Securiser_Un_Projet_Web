<?php
    session_start();
    include 'database.php';

    // On vérifie le CSRF token avant quoi que ce soit
    if (isset($_POST["token"]) && $_POST["token"] != $_SESSION["csrf_article_add"]) {
        $_SESSION['message'] = "CSRF invalide";
        header("Location: index.php?form=login");
        exit();
    }

    // Supprime le token en session pour qu'il soit régénéré
    unset($_SESSION["csrf_article_add"]);

    // Initialisation des variables
    $email = $password = "";
    $errors = [];

    // Vérification de l'email
    if (isset($_POST["Email"]) && !empty($_POST["Email"])) {
        $email = htmlspecialchars($_POST["Email"]);
    } else {
        $errors[] = "L'email est obligatoire";
    }

    // Vérification du mot de passe
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $password = $_POST["password"];
    } else {
        $errors[] = "Le mot de passe est obligatoire";
    }

    // Si des erreurs sont présentes, on les stocke dans la session et on redirige
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php?form=login");
        exit();
    }

    // Vérification des données dans la base de données
    $sql = "SELECT id, username, password, is_admin FROM user WHERE email = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Définir des variables de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $email;
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: page.php");
            exit();
        } else {
            $_SESSION['message'] = "Mot de passe incorrect";
            header("Location: index.php?form=login");
            exit();
        }
    } else {
        $_SESSION['message'] = "Email non trouvé";
        header("Location: index.php?form=login");
        exit();
    }
?>