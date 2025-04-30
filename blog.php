<?php
session_start();
include 'includes/db.php';

$result = $conn->query("
    SELECT posts.*, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    WHERE posts.reported = 0
    ORDER BY posts.created_at DESC
");

include 'includes/header.php';  // Include header
?>

<div class="page-blog content">
    <h2>All Blog Posts</h2>
    <div class="blog-links">
        <a href="index.php">🏠 Home</a> |
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">📋 Dashboard</a> |
            <a href="users/logout.php">🔒 Logout</a>
        <?php else: ?>
            <a href="users/login.php">🔐 Login</a>
        <?php endif; ?>
    </div>
    <hr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="blog-card">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <small>By: <?php echo htmlspecialchars($row['username']); ?> | 
            <?php echo date('M d, Y', strtotime($row['created_at'])); ?></small>
            <p><?php echo substr(strip_tags($row['content']), 0, 150) . '...'; ?></p>
            <a href="posts/view_post.php?id=<?php echo $row['id']; ?>">👁 Read More</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                | <a href="reports/report.php?post_id=<?php echo $row['id']; ?>" onclick="return confirm('Report this post?');">⚠️ Report</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
