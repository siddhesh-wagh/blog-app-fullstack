<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);
        if ($stmt->execute()) {
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Failed to post. Try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}

include '../includes/header.php';  // Include header
?>

<h2>Create New Blog Post</h2>
<form method="POST">
    Title: <input type="text" name="title" required><br><br>
    Content:<br>
    <textarea name="content" rows="8" cols="60" required></textarea><br><br>
    <button type="submit">Publish</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<?php include '../includes/footer.php';  // Include footer ?>
