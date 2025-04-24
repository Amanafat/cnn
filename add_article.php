<?php
session_start();
require '../config.php'; // Ensure config.php is correctly set up

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize messages
$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $uploadDir = '../uploads/';

    // Validate inputs
    if (empty($title) || empty($content) || empty($category)) {
        $error = "❌ Error: All fields are required.";
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Ensure 'uploads/' folder exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        // Allowed image types
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Get file extension and MIME type
        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $fileMimeType = mime_content_type($_FILES['image']['tmp_name']);

        // Validate image type
        if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileMimeType, $allowedMimeTypes)) {
            $error = "❌ Error: Invalid image format! Only JPG, PNG, and GIF allowed.";
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            chmod($targetFilePath, 0644);
            $imagePath = $imageName; // Save image filename in the database

            // Insert article into database
            $stmt = $pdo->prepare("INSERT INTO articles (title, image, content, category, created_at) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([$title, $imagePath, $content, $category])) {
                $success = "✅ Article added successfully!";
            } else {
                $error = "❌ Error: Could not add article.";
            }
        } else {
            $error = "❌ Error: Failed to upload image. Check folder permissions.";
        }
    } else {
        $error = "❌ Error: No image uploaded or file is too large.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Add New Article</h2>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form action="add_article.php" method="POST" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Image:</label>
    <input type="file" name="image" accept="image/*" required><br>

    <label>Content:</label>
    <textarea name="content" rows="5" required></textarea><br>

    <label>Category:</label>
    <select name="category" required>
        <option value="Politics">Politics</option>
        <option value="Sports">Sports</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Technology">Technology</option>
    </select><br>

    <button type="submit">Add Article</button>
</form>

</body>
</html>
