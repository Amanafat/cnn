<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    die("Invalid article.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['title'] ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <article>
            <h1><?= $article['title'] ?></h1>
            <img src="uploads/<?= $article['image'] ?>" alt="<?= $article['title'] ?>">
            <p><?= nl2br($article['content']) ?></p>
        </article>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
