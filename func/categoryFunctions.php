<?php
require_once 'connection.php';

// Function to get all categories
function getCategories() {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// Function to create a category
function createCategory($name, $color) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        // Store the color in cookies
        setCategoryColor($name, $color);
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// Function to delete a category
function deleteCategory($id, $name) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Remove the color cookie
        setCategoryColor($name, '', true); // Remove the cookie
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// Function to update a category
function updateCategory($id, $name, $color) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        // Update the color in cookies
        setCategoryColor($name, $color);
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>
