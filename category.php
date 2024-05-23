<?php
session_start();
require_once 'func/categoryFunctions.php';
require_once 'func/colorFunctions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $userId = $_SESSION['id'];
        createCategory($_POST['name'], $userId);
    } elseif (isset($_POST['delete'])) {
        deleteCategory($_POST['id']);
    } elseif (isset($_POST['update'])) {
        updateCategory($_POST['id'], $_POST['name']);
    }
}

$userId = $_SESSION['id'];
$categories = getCategoriesByUserId($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="./src/register1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:ital,wght@0,400..700;1,400..700&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="font-familjen-grotesk flex flex-col h-screen p-4 box-border text-white bg-center bg-no-repeat bg-cover" style="background-image: url('https://images.unsplash.com/photo-1500417148159-68083bd7333a');">
        <header>
            <nav class="bg-white border-b-2 border-gray-200 py-4 rounded-xl">
                <div class="container mx-auto flex justify-between items-center">
                    <a href="#" class="flex items-center text-lg font-semibold text-gray-800">
                        Task Manager
                    </a>
                    <ul class="flex space-x-8">
                        <li>
                            <a href="home.php" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Home</a>
                        </li>
                        <li>
                            <a href="task.php" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Tasks</a>
                        </li>
                        <li>
                            <a href="category.php" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Categories</a>
                        </li>
                        <li>
                            <a href="func/logout.php" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Log out</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <main class="container mx-auto">
            <section class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Manage Categories</h1>
                <form action="category.php" method="POST" class="flex space-x-4 mb-4 bg-white p-4 rounded">
                    <input type="text" name="name" placeholder="Category Name" class="w-full p-2 rounded border border-gray-300">
                    <input type="color" name="color" value="#ffffff" class="p-2 rounded border border-gray-300">
                    <button type="submit" name="create" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                </form>
                <div id="categories" class="grid grid-cols-1 gap-4">
                    <?php foreach ($categories as $category): 
                        $name = $category['name'];
                        $color = getCategoryColor($userId , $name);
                    ?>
                        <div class="flex justify-between items-center p-4 rounded shadow" style="background-color: <?= htmlspecialchars($color) ?>">
                            <span class="text-black"><?= htmlspecialchars($name) ?></span>
                            <div class="flex space-x-2">
                                <form action="category.php" method="POST" class="flex items-center">
                                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="p-1 rounded border border-gray-300 mr-2">
                                    <input type="color" name="color" value="<?= htmlspecialchars($color) ?>" class="p-1 rounded border border-gray-300 mr-2">
                                    <button type="submit" name="update" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                </form>
                                <form action="category.php" method="POST" class="flex items-center">
                                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
                                    <button type="submit" name="delete" class="bg-red-500 text-black px-2 py-1 rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
