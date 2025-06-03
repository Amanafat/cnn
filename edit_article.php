<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE articles SET title = ?, content = ?, category = ? WHERE id = ?");
    if ($stmt->execute([$title, $content, $category, $id])) {
        echo "Article updated. <a href='dashboard.php'>Go back</a>";
    } else {
        echo "Error updating article.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Edit News</h2>
    <form action="edit_article.php" method="post">
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
        <input type="text" name="title" value="<?= $article['title'] ?>" required>
        <textarea name="content" required><?= $article['content'] ?></textarea>
        <select name="category">
            <option value="Politics" <?= ($article['category'] == 'Politics') ? 'selected' : '' ?>>Politics</option>
            <option value="Sports" <?= ($article['category'] == 'Sports') ? 'selected' : '' ?>>Sports</option>
            <option value="Tech" <?= ($article['category'] == 'Tech') ? 'selected' : '' ?>>Tech</option>
        </select>
        <button type="submit">Update News</button>
    </form>
</body>
</html>
