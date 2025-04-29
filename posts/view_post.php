<?php
session_start();
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "Invalid post.";
    exit;
}

$post_id = intval($_GET['id']);

// Decide which query to use based on role
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Admin sees everything
    $stmt = $conn->prepare("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ?
    ");
    $stmt->bind_param("i", $post_id);
} else {
    // Regular users only see non-reported posts
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

<h2><?php echo htmlspecialchars($post['title']); ?></h2>
<p><em>By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('M d, Y', strtotime($post['created_at'])); ?></em></p>
<div><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>

<p>
  <a href="/blog-app-fullstack/blog.php">⬅ Back to Blog</a>
  <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin'): ?>
    | <a href="/blog-app-fullstack/reports/report.php?post_id=<?php echo $post['id']; ?>" onclick="return confirm('Report this post?');">⚠️ Report</a>
  <?php endif; ?>
</p>

<?php include '../includes/footer.php'; ?>
