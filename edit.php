<?php
    session_start();
    include 'database.php';

    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "Vous devez être connecté pour modifier un article";
        header("Location: page.php");
        exit();
    }

    // Vérifiez si l'utilisateur est admin
    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

    // Récupération de l'ID du post
    $post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Vérification de l'existence du post et de l'autorisation de modification
    $sql = "SELECT * FROM post WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        $_SESSION['message'] = "Article non trouvé";
        header("Location: page.php");
        exit();
    }

    if (!$is_admin && $post['user_id'] != $_SESSION['user_id']) {
        $_SESSION['message'] = "Vous n'avez pas l'autorisation de modifier cet article";
        header("Location: page.php");
        exit();
    }

    // Traitement de la modification
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
        $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';

        if (empty($title) || empty($content)) {
            $_SESSION['message'] = "Le titre et le contenu sont obligatoires";
            header("Location: edit.php?id=$post_id");
            exit();
        } else {
            $sql = "UPDATE post SET title = ?, content = ? WHERE id = ?";
            $stmt = $connexion->prepare($sql);
            if ($stmt->execute([$title, $content, $post_id])) {
                $_SESSION['message'] = "Article modifié avec succès";
                header("Location: page.php");
                exit();
            } else {
                $_SESSION['message'] = "Erreur lors de la modification de l'article";
                header("Location: edit.php?id=$post_id");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Modifier un Post</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='text-red-500'>" . htmlspecialchars($_SESSION['message']) . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <form action="" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre :</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu :</label>
                <textarea name="content" id="content" rows="10" cols="30" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div>
                <input type="submit" value="Modifier" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
            </div>
        </form>
    </div>
</body>
</html>