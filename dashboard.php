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
    $adminRequestMessage = "✅ Request sent to admin!";
}

// Get current user's posts
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<div class="page-dashboard content">
    <h2>👋 Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

    <?php if (!empty($adminRequestMessage)): ?>
        <p class="success-message"><?= $adminRequestMessage ?></p>
    <?php endif; ?>

    <div class="dashboard-actions">
        <a href="posts/add_post.php" class="btn">➕ Create New Post</a>
        <a href="users/logout.php" class="btn logout">🔒 Logout</a>
    </div>

    <?php if ($_SESSION['role'] === 'user'): ?>
        <form method="POST" class="admin-request-form">
            <button type="submit" name="request_admin">🚀 Request Admin Access</button>
        </form>
    <?php endif; ?>

    <hr>

    <h3>Your Posts</h3>
    <?php if ($result->num_rows > 0): ?>
        <div class="dashboard-posts">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <h4><?= htmlspecialchars($row['title']) ?></h4>
                    <p><?= substr(strip_tags($row['content']), 0, 100) . '...' ?></p>
                    <div class="post-links">
                        <a href="posts/view_post.php?id=<?= $row['id'] ?>">👁 View</a> |
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">🗑 Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>You haven't written any posts yet.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
