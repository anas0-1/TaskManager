<?php
// Include database connection file
require_once 'connection.php';

// Query to retrieve tasks from the database
$sql = "SELECT * FROM tasks";

try {
    // Get database connection
    $conn = getDatabaseConnection();

    // Prepare and execute the query
    $stmt = $conn->query($sql);

    // Fetch tasks data as an associative array
    $tasksData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output tasks data as JSON
    header('Content-Type: application/json');
    echo json_encode($tasksData);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
