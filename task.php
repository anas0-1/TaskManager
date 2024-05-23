<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="src/register1.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:ital,wght@0,400..700;1,400..700&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./login.html");
    exit;
}
?>

<body>
    <div class="font-familjen-grotesk flex flex-col  h-screen p-4 box-border text-white bg-center bg-no-repeat bg-cover"
        style="background-image: url('https://images.unsplash.com/photo-1500417148159-68083bd7333a');">
        <header>
            <nav class="bg-white border-b-2 border-gray-200 py-4">
                <div class="container mx-auto flex justify-between items-center">
                    <a href="#" class="flex items-center text-lg font-semibold text-gray-800">Task Manager</a>
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
        <main class="flex justify-between mt-[40px] items-start">
            <!-- Task Display Section -->
            <?php
            // Include the database connection file
            require_once 'func/connection.php';

            $user_id = $_SESSION['id'];

            // Query to retrieve tasks for the logged-in user
            $sql = "SELECT * FROM tasks WHERE user_id = :user_id";

            try {
                // Get database connection
                $conn = getDatabaseConnection();

                // Prepare and execute the query
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                // Fetch tasks
                $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                // Handle errors
                echo "Error: " . $e->getMessage();
            }
            ?>

            <!-- Display tasks in the first section -->
            <section class="w-1/2 bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold text-gray-700 mb-4">All Tasks</h2>
                <div class="task-list">
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-item flex justify-between items-center bg-gray-100 p-3 rounded-lg mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800"><?php echo $task['title']; ?></h3>
                                <p class="text-gray-600"><?php echo $task['description']; ?></p>
                                <p class="text-gray-500 text-sm">
                                    <?php echo $task['start_time'] . ' - ' . $task['end_time']; ?>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-blue-500 hover:underline">Edit</button>
                                <button class="text-red-500 hover:underline">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Task Creation Section -->
            <section class="w-1/3 bg-gray-100 p-4 rounded-lg shadow-lg">
                <div class="flex flex-col p-4 gap-4 bg-white rounded-lg">
                    <div class="new-task">
                        <h1 class="font-bold px-2 text-sm text-gray-700">Create Task</h1>
                        <div class="tags mt-2">
                            <h2 class="font-bold text-sm text-gray-700">Task Category</h2>
                            <!-- Styled dropdown menu for selecting category -->
                            <div class="relative">
    <?php
    require_once 'func/createtask.php'; // Include the createtask script
    $categories = getCategories($user_id); // Fetch categories
    echo '<select name="category_id" class="p-2 rounded border border-gray-300">';
    foreach ($categories as $category):
        echo '<option class="p-2 rounded border border-gray-300 text-black" value="' . $category['id'] . '">' . $category['name'] . '</option>';
    endforeach;
    echo '</select>';
    ?>
</div>

                        </div>
                    </div>
                    <div class="task-details mt-2">
                        <form class="task-create text-gray-700" action="func/createtask.php" method="POST">
                            <input name="title"
                                class="task-title w-full bg-gray-100 rounded-md py-1 px-2 text-xs border border-gray-300"
                                type="text" placeholder="Title" />
                            <input name="description"
                                class="task-description w-full bg-gray-100 rounded-md py-1 px-2 text-xs border border-gray-300 mt-1"
                                type="text" placeholder="Description" />
                            <input name="start_time"
                                class="w-full bg-gray-100 rounded-md py-1 px-2 text-xs border border-gray-300 mt-1"
                                type="text" placeholder="🗓️ Start Time (e.g., 10:00am)" />
                            <input name="end_time"
                                class="w-full bg-gray-100 rounded-md py-1 px-2 text-xs border border-gray-300 mt-1"
                                type="text" placeholder="🗓️ End Time (e.g., 11:30am)" />
                            <!-- Add hidden input field for form submission indicator -->
                            <input type="hidden" name="submit" value="1">
                            <button type="submit"
                                class="create bg-gradient-to-r from-pink-500 to-red-500 text-white py-1 px-2 rounded-md mt-3 text-xs">Create</button>
                        </form>
                    </div>
                </div>
            </section>

        </main>
    </div>
</body>
<script>
    // Update the displayed text of the dropdown when an option is selected
    document.getElementById('categorySelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var displayText = selectedOption.textContent;
        this.previousElementSibling.textContent = displayText;
    });
</script>

</html>