<?php
    session_start();
    include 'database.php';

    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    // Si on n'a pas de csrf token, on en crée un
    if (!isset($_SESSION["csrf_article_add"]) || empty($_SESSION["csrf_article_add"])) {
        $_SESSION["csrf_article_add"] = bin2hex(random_bytes(32));
    }

    // Vérifiez si l'utilisateur est connecté et s'il est admin
    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Ajouter un Post</h1>
            <form action="logout.php" method="POST">
                <input type="submit" value="Déconnexion" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">
            </form>
        </div>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='text-red-500'>" . htmlspecialchars($_SESSION['message']) . "</p>";
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p class='text-red-500'>" . htmlspecialchars($error) . "</p>";
            }
            unset($_SESSION['errors']);
        }
        ?>
        <form action="traitement.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre :</label>
                <input type="text" name="title" id="title" placeholder="Titre du Post" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu :</label>
                <textarea name="content" id="content" placeholder="Contenu du post..." rows="10" cols="30" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION["csrf_article_add"]; ?>">
            <div>
                <input type="submit" name="ajouter" value="Ajouter" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
            </div>
        </form>

        <h2 class="text-2xl font-bold mt-8 mb-4">Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($posts as $post): ?>
                <div class="bg-white p-6 rounded-lg shadow-md relative">
                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <p class="text-sm text-gray-500 absolute top-2 right-2">Posté par : <?php echo htmlspecialchars($post['username']); ?></p>

                    <?php if ($is_admin || $post['user_id'] == $user_id): ?>
                        <form action="delete.php" method="POST" class="mt-4">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <input type="hidden" name="token" value="<?php echo $_SESSION["csrf_article_add"]; ?>">
                            <input type="submit" name="delete" value="Supprimer" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">
                        </form>
                        <a href="edit.php?id=<?php echo $post['id']; ?>" class="w-full bg-yellow-500 text-white py-2 px-4 rounded-md hover:bg-yellow-600 block text-center mt-2">Modifier</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>