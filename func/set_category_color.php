<?php
session_start();

if (isset($_POST['category']) && isset($_POST['color'])) {
    $category = $_POST['category'];
    $color = $_POST['color'];
    $_SESSION['category_colors'][$category] = $color;
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
?>
