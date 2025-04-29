<?php
session_start();
include '../includes/db.php';

// Check if admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Handle delete post
if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    $conn->query("DELETE FROM posts WHERE id = $post_id");
}

// Handle unreport post
if (isset($_GET['unreport'])) {
    $post_id = intval($_GET['unreport']);
    $conn->query("UPDATE posts SET reported = 0 WHERE id = $post_id");
}

// Fetch reported posts
$result = $conn->query("
    SELECT posts.*, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    WHERE posts.reported = 1
");
?>

<h2>Admin Panel</h2>

<a href="../index.php">🏠 Home</a> |
<a href="../dashboard.php">📋 Dashboard</a> |
<a href="../users/logout.php">🔒 Logout</a>

<hr>

<h3>Reported Posts</h3>
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border:1px solid red; padding:10px; margin-bottom:10px;">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <small>By <?php echo htmlspecialchars($row['username']); ?> | <?php echo date('M d, Y', strtotime($row['created_at'])); ?></small>
            <p><?php echo substr(strip_tags($row['content']), 0, 150) . '...'; ?></p>

            <a href="../posts/view_post.php?id=<?php echo $row['id']; ?>">👁 View</a> |
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete?')">🗑 Delete</a> |
            <a href="?unreport=<?php echo $row['id']; ?>" onclick="return confirm('Mark as safe?')">✅ Mark Safe</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No reported posts 🎉</p>
<?php endif; ?>
