<?php
session_start();
require 'config.php'; // Ensure config.php is properly set up

// Fetch all articles
$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to My CNN Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #d60000;
            font-size: 32px;
        }
        .article {
            text-align: left;
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }
        .article img {
            width: 100%;
            max-width: 600px;
            height: auto;
            display: block;
            margin: 10px auto;
            border-radius: 5px;
        }
        .article h2 {
            color: #333;
        }
        .article p {
            color: #666;
        }
        .category {
            background: #007BFF;
            color: white;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to My CNN Clone</h1>

    <?php if (empty($articles)): ?>
        <p>No articles found.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <span class="category"><?php echo htmlspecialchars($article['category']); ?></span>
                <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                
                <?php if (!empty($article['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image">
                <?php endif; ?>

                <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                <p><strong>Published on:</strong> <?php echo date("F j, Y", strtotime($article['created_at'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</body>
</html>
