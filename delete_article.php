<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    if ($stmt->execute([$_GET['id']])) {
        echo "Article deleted. <a href='dashboard.php'>Go back</a>";
    } else {
        echo "Error deleting article.";
    }
}
?>
