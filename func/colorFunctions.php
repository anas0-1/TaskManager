<?php
// Get category color from cookies
function getCategoryColor($name) {
    return isset($_COOKIE["category_color_$name"]) ? $_COOKIE["category_color_$name"] : '#ffffff';
}

// Set category color in cookies
function setCategoryColor($name, $color, $delete = false) {
    if ($delete) {
        setcookie("category_color_$name", '', time() - 3600, "/");
    } else {
        setcookie("category_color_$name", $color, time() + (86400 * 30), "/"); // 30 days expiry
    }
}
?>
