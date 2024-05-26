<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User not logged in.";
    exit;
}

// Check if a file was uploaded
if (isset($_FILES['tasks_file']) && $_FILES['tasks_file']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file path
    $tmpFilePath = $_FILES['tasks_file']['tmp_name'];

    // Read the JSON data from the file
    $jsonContent = file_get_contents($tmpFilePath);

    // Parse JSON data
    $tasksData = json_decode($jsonContent, true);

    if ($tasksData) {
        // Include database connection file
        require_once 'connection.php';

        try {
            // Get database connection
            $conn = getDatabaseConnection();

            // Prepare statement for inserting tasks
            $stmt = $conn->prepare("INSERT INTO tasks (title, description, start_time, end_time, user_id, category_id) VALUES (:title, :description, :start_time, :end_time, :user_id, :category_id)");

            // Get user ID from session
            $userId = $_SESSION['id'];

            // Loop through each task in the imported data
            foreach ($tasksData as $task) {
                // Bind parameters and execute the statement
                $stmt->bindParam(':title', $task['title']);
                $stmt->bindParam(':description', $task['description']);
                $stmt->bindParam(':start_time', $task['start_time']);
                $stmt->bindParam(':end_time', $task['end_time']);
                $stmt->bindParam(':user_id', $userId); // Use user ID from session
                $stmt->bindParam(':category_id', $task['category_id']);
                $stmt->execute();
            }

            echo "Tasks imported successfully.";

        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    } else {
       echo "<script>alert('Invalid JSON file.');</script>";
    }
} else {
    echo "<script>alert('please select a file.');</script>";
}
?>
