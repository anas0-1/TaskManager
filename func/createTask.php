<?php

require_once 'connection.php'; // Include the connection script

// Function to create a new task in the database
function createTask($title, $description, $start_time, $end_time, $user_id, $category_id)
{
    try {
        // Get database connection
        $conn = getDatabaseConnection();

        // Prepare SQL statement to insert a new task
        $sql = "INSERT INTO tasks (title, description, start_time, end_time, user_id, category_id) VALUES (:title, :description, :start_time, :end_time, :user_id, :category_id)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);

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

    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $category_id = $_POST['category_id']; // Ensure category_id is properly set in the form

        // Debugging: Output form data
        echo "Received form data: ";
        var_dump($_POST);

        // Debugging: Output category ID
        echo "Received category ID: " . $category_id;

        // Call createTask function
        createTask($title, $description, $start_time, $end_time, $user_id, $category_id);
    }
} else {
    echo "User ID not found in session.";
}
?>