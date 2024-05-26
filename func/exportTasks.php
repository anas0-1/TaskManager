<?php

require_once 'connection.php';

session_start();


if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User is not logged in.']);
    exit;
}

// user id and idrole
$user_id = $_SESSION['id'];
$user_role = $_SESSION['idrole'];


if ($user_role == 1) {
    // Admin 
    $sql = "SELECT * FROM tasks";
} else {
    // user
    $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
}

try {

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare($sql);
    
    if ($user_role != 1) {
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    }

    $stmt->execute();

    $tasksData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output tasks data as JSON
    header('Content-Type: application/json');
    echo json_encode($tasksData);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
