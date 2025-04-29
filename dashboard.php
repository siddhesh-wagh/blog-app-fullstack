<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: users/login.php");
    exit;
}

include 'includes/db.php';
include 'includes/header.php';

// Handle delete (only delete own posts)
if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
}

// Handle admin request
if (isset($_POST['request_admin']) && $_SESSION['role'] === 'user') {
    $user_id = $_SESSION['user_id'];
    $conn->query("UPDATE users SET admin_requested = 1 WHERE id = $user_id");
    echo "<p style='color:green;'>✅ Request sent to admin!</p>";
}

// Get current user's posts
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<h2>👋 Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

<a href="posts/add_post.php">➕ Create New Post</a> |
<a href="users/logout.php">🔒 Logout</a>

<?php if ($_SESSION['role'] === 'user'): ?>
    <form method="POST" style="margin-top: 10px;">
        <button type="submit" name="request_admin">🚀 Request Admin Access</button>
    </form>
<?php endif; ?>

<hr>

<h3>Your Posts</h3>
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h4><?= htmlspecialchars($row['title']) ?></h4>
            <p><?= substr(strip_tags($row['content']), 0, 100) . '...' ?></p>
            <a href="posts/view_post.php?id=<?= $row['id'] ?>">👁 View</a> |
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">🗑 Delete</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>You haven't written any posts yet.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
