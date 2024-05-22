<?php
session_start();
error_log("Script is being executed.");
require_once 'connection.php';

function registerUser($username, $email, $password, $confirm_password) {
    error_log("Username: $username");
    error_log("Email: $email");
    error_log("Password: $password");
    error_log("Confirm Password: $confirm_password");

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        error_log("All fields are filled.");

        if ($password === $confirm_password) {
            error_log("Passwords match.");

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Get database connection
                $conn = getDatabaseConnection();
                
                // Insert user data into database
                $stmt = $conn->prepare("INSERT INTO user (username, email, password, idrole) VALUES (:username, :email, :password, 2)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                
                $stmt->execute();

                error_log("User registered successfully.");
                // Set session variable
                $_SESSION['username'] = $username; 
                // Redirect to success page or do something else
                header("Location: ../login.html");
                exit();
            } catch(PDOException $e) {
                error_log("Error: " . $e->getMessage());
                echo "Error: " . $e->getMessage();
            }
        } else {
            error_log("Passwords do not match.");
            echo "Passwords do not match.";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Form submitted.");
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    registerUser($username, $email, $password, $confirm_password);
} else {
    error_log("Form not submitted.");
    echo "Form not submitted.";
}
?>
