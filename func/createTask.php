<?php

require_once 'connection.php'; // Include the connection script

// Function to create a new task in the database
function createTask($title, $description, $start_time, $end_time, $category_id, $user_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to insert the task
        $sql = "INSERT INTO tasks (title, description, start_time, end_time, category_id, user_id) VALUES (:title, :description, :start_time, :end_time, :category_id, :user_id)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        echo "Task created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }
}

// Function to update a task in the database
function updateTask($task_id, $title, $description, $start_time, $end_time, $category_id, $user_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to update the task
        $sql = "UPDATE tasks SET title = :title, description = :description, start_time = :start_time, end_time = :end_time, category_id = :category_id WHERE idtask = :task_id AND user_id = :user_id";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        echo "Task updated successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }
}

// Fetch categories from the database
function getCategories($user_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to fetch categories
        $sql = "SELECT id, name FROM categories WHERE user_id = :user_id";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        // Fetch categories
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }
}

// Check if session is started
if (!isset($_SESSION)) {
    session_start();
}

// Check if user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Check if task details are provided
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['category_id'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $category_id = $_POST['category_id'];

        // Check if we are creating or updating a task
        if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['task_id'])) {
            $task_id = $_POST['task_id'];
            // Call updateTask function
            updateTask($task_id, $title, $description, $start_time, $end_time, $category_id, $user_id);
        } else {
            // Call createTask function
            createTask($title, $description, $start_time, $end_time, $category_id, $user_id);
        }
    } else {
        echo "Task details not provided.";
    }
} else {
    echo "User ID not found in session.";
}
?>