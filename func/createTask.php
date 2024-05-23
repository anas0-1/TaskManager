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
