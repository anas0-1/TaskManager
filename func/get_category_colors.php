<?php
session_start();

if (isset($_SESSION['category_colors'])) {
    echo json_encode(['status' => 'success', 'colors' => $_SESSION['category_colors']]);
} else {
    echo json_encode(['status' => 'success', 'colors' => []]);
}
?>
