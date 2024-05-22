<?php
session_start();
error_log("Script is being executed.");
require_once 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Form submitted.");
    
    $email_username = $_POST['email_username'];
    $password = $_POST['password'];

    // Validate input fields
    if (!empty($email_username) && !empty($password)) {
        try {
            // Get database connection
            $conn = getDatabaseConnection();
            
            // Prepare and execute the query to check user credentials
            $stmt = $conn->prepare("SELECT * FROM user WHERE (username = :email_username OR email = :email_username)");
            $stmt->bindParam(':email_username', $email_username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists and password is correct
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect based on idrole
                if ($user['idrole'] == 1) {
                    header("Location: ../admin.html");
                } else {
                    header("Location: ../home.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid username/email or password.');</script>";
            }
        } catch(PDOException $e) {
            error_log("Error: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
} else {
    error_log("Form not submitted.");
}
?>
