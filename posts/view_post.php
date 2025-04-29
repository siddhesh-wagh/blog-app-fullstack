<?php
session_start();
include '../includes/db.php';

// Validate post ID
if (!isset($_GET['id'])) {
    echo "Invalid post.";
    exit;
}

$post_id = intval($_GET['id']);
$stmt = $conn->prepare("
    SELECT posts.*, users.username
    FROM posts
    JOIN users ON posts.user_id = users.id
    WHERE posts.id = ? AND posts.reported = 0
");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post not found.";
    exit;
}

$post = $result->fetch_assoc();

include '../includes/header.php';
?>

<h2><?php echo htmlspecialchars($post['title']); ?></h2>
<p><em>
    By <?php echo htmlspecialchars($post['username']); ?> | 
    <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
</em></p>

<div>
    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
</div>

<p>
    <a href="/blog-app-fullstack/blog.php">⬅ Back to Blog</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        | <a href="/blog-app-fullstack/reports/report.php?post_id=<?php echo $post['id']; ?>"
             onclick="return confirm('Report this post?');">⚠️ Report</a>
    <?php endif; ?>
</p>

<?php include '../includes/footer.php'; ?>
