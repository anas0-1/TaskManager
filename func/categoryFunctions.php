<?php
require_once 'connection.php';

function getCategoriesByUserId($userId) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM categories WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

function createCategory($name, $userId) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("INSERT INTO categories (name, user_id) VALUES (:name, :userId)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

function deleteCategory($id) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

function updateCategory($id, $name) {
    try {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: category.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>
