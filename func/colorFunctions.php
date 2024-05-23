<?php
// Get category color from cookies
function getCategoryColor($userId, $name) {
    $cookieName = "category_color_" . $userId . "_" . $name;
    return isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : '#ffffff';
}


// Set category color in cookies
function setCategoryColor($userId, $name, $color, $delete = false) {
    $cookieName = "category_color_" . $userId . "_" . $name;
    if ($delete) {
        setcookie($cookieName, '', time() - 3600, "/");
    } else {
        setcookie($cookieName, $color, time() + (86400 * 30), "/"); // 30 days expiry
    }
}


?>
