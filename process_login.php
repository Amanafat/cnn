<?php
session_start();
$admin_username = "admin";
$admin_password = "admin123"; // Change this

if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
    $_SESSION['admin'] = true;
    header("Location: admin/dashboard.php");
} else {
    echo "Invalid login.";
}
?>
