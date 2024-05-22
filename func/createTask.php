<?php
session_start();
require_once 'connection.php'; // Include the connection script

// Function to create a new task in the database
function createTask($title, $description, $start_time, $end_time, $user_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to insert a new task
        $sql = "INSERT INTO tasks (title, description, start_time, end_time, user_id) VALUES (:title, :description, :start_time, :end_time, :user_id)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        echo "New task created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Retrieve user ID from session
    $user_id = $_SESSION['id'];

    // Call createTask function with form data and user ID
    createTask($title, $description, $start_time, $end_time, $user_id);
}
?>
