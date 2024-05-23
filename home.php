<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./src/register1.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:ital,wght@0,400..700;1,400..700&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./login.html");
    exit;
}
?>

<body>
    <div class="font-familjen-grotesk flex flex-col justify-between h-screen p-4 box-border text-white bg-center bg-no-repeat bg-cover"
        style="background-image: url('https://images.unsplash.com/photo-1500417148159-68083bd7333a');">
        <header>
            <nav class="bg-white border-b-2 border-gray-200 py-4 rounded-xl">
                <div class="container mx-auto flex justify-between items-center">
                    <a href="#" class="flex items-center text-lg font-semibold text-gray-800">
                        Task Manager
                    </a>
                    <ul class="flex space-x-8">
                        <li>
                            <a href="home.php"
                                class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Home</a>
                        </li>
                        <li>
                            <a href="task.php"
                                class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Tasks</a>
                        </li>
                        <li>
                            <a href="category.php"
                                class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Categories</a>
                        </li>
                        <li>
                            <a href="func/logout.php"
                                class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Log
                                out</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <section class="welcome-section text-white flex items-center justify-center h-full">
            <h1 class="pr-4 border-r-4 border-white text-4xl">TASK MANAGING</h1>
            <p class="pl-4 text-4xl">Manage your tasks with flexibility</p>
        </section>
        <section class="welcome-section text-white flex items-center justify-center h-full">
            <form id="importTasksForm" action="func/importTasks.php" method="POST" enctype="multipart/form-data">
             <input type="file" name="tasks_file" accept=".json" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">
             <button type="submit"class="text-white-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Import Tasks</button>
            </form>
             <button id="exportTasksBtn" class="text-white-700 hover:bg-gray-100 hover:text-blue-700 px-3 py-2 rounded">Export Tasks</button>
            </section>
    </div>
    <script src="./js/import_export.js"></script>
</body>
</html>
