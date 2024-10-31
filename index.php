<?php
    session_start();

    // Si on n'a pas de csrf token, on en crée un
    if (!isset($_SESSION["csrf_article_add"]) || empty($_SESSION["csrf_article_add"])) {
        $_SESSION["csrf_article_add"] = bin2hex(random_bytes(32));
    }
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
    <div class="h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <?php
            $form = isset($_GET['form']) ? $_GET['form'] : 'login';
            ?>
            <h2 class="text-2xl font-bold mb-6 text-center">
                <?php echo $form === 'login' ? 'Login' : 'Register'; ?>
            </h2>
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
            <?php
            if ($form === 'login') {
            ?>
                <form action="login.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="login">
                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" name="Email" placeholder="Email" autocomplete="off" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION["csrf_article_add"]; ?>">
                    <div>
                        <input type="submit" name="ajouter" value="Login" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    </div>
                </form>
                <div class="mt-6 text-center">
                    <a href="?form=register" class="text-indigo-600 hover:text-indigo-900">Register</a>
                </div>
            <?php
            } else if ($form === 'register') {
            ?>
                <form action="register.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="register">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" placeholder="Username" autocomplete="off" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="Email" placeholder="Email" autocomplete="off" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION["csrf_article_add"]; ?>">
                    <div>
                        <input type="submit" name="register" value="Register" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    </div>
                </form>
                <div class="mt-6 text-center">
                    <a href="?form=login" class="text-indigo-600 hover:text-indigo-900">Login</a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>