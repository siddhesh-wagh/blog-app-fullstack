<?php
session_start();
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "Invalid post.";
    exit;
}

$post_id = intval($_GET['id']);

// Query logic
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $stmt = $conn->prepare("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ?
    ");
    $stmt->bind_param("i", $post_id);
} else {
    $stmt = $conn->prepare("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ? AND posts.reported = 0
    ");
    $stmt->bind_param("i", $post_id);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post not found.";
    exit;
}

$post = $result->fetch_assoc();
include '../includes/header.php';
?>

<div class="page-view-post content">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p class="post-meta"><em>By <?= htmlspecialchars($post['username']) ?> on <?= date('M d, Y', strtotime($post['created_at'])) ?></em></p>

    <div class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

    <p class="post-actions">
        <a href="/blog-app-fullstack/blog.php">⬅ Back to Blog</a>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin'): ?>
            | <a href="/blog-app-fullstack/reports/report.php?post_id=<?= $post['id'] ?>" onclick="return confirm('Report this post?');">⚠️ Report</a>
        <?php endif; ?>
    </p>
</div>

<?php include '../includes/footer.php'; ?>
