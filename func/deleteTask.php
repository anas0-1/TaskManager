<?php
require_once 'connection.php'; // Include the connection script

// Function to delete a task from the database
function deleteTask($task_id, $user_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to delete the task
        $sql = "DELETE FROM tasks WHERE idtask = :task_id AND user_id = :user_id";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        echo "Task deleted successfully";
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

    // Check if task ID is provided
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];

        // Call deleteTask function
        deleteTask($task_id, $user_id);
    } else {
        echo "Task ID not provided.";
    }
} else {
    echo "User ID not found in session.";
}
?>
