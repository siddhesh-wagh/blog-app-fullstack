<?php
session_start();
include '../includes/db.php';

// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$base = '/blog-app-fullstack'; // base URL for links

// Handle delete post
if (isset($_GET['delete_post'])) {
    $post_id = intval($_GET['delete_post']);
    $conn->query("DELETE FROM posts WHERE id = $post_id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle unreport post
if (isset($_GET['unreport'])) {
    $post_id = intval($_GET['unreport']);
    $conn->query("UPDATE posts SET reported = 0 WHERE id = $post_id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle delete user
if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $conn->query("DELETE FROM users WHERE id = $user_id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Get stats
$total_users    = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_posts    = $conn->query("SELECT COUNT(*) AS count FROM posts")->fetch_assoc()['count'];
$reported_posts = $conn->query("SELECT COUNT(*) AS count FROM posts WHERE reported = 1")->fetch_assoc()['count'];

// Get reported posts
$reported_result = $conn->query(
    "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.reported = 1"
);

// Get all users
$users_result = $conn->query("SELECT * FROM users");

include '../includes/header.php';
?>

<h2>🛠 Admin Dashboard</h2>

<p>
    <a href="<?php echo $base; ?>/index.php">🏠 Home</a> |
    <a href="<?php echo $base; ?>/dashboard.php">📋 Dashboard</a> |
    <a href="<?php echo $base; ?>/users/logout.php">🔒 Logout</a>
</p>

<hr>
<h3>📊 Site Stats</h3>
<ul>
    <li>Total Users: <?php echo $total_users; ?></li>
    <li>Total Posts: <?php echo $total_posts; ?></li>
    <li>Reported Posts: <?php echo $reported_posts; ?></li>
</ul>

<hr>
<h3>🚨 Reported Posts</h3>
<?php if ($reported_result->num_rows > 0): ?>
    <?php while ($row = $reported_result->fetch_assoc()): ?>
        <div style="border:1px solid red; padding:10px; margin-bottom:10px;">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <small>By <?php echo htmlspecialchars($row['username']); ?> | <?php echo date('M d, Y', strtotime($row['created_at'])); ?></small>
            <p><?php echo htmlspecialchars(substr(strip_tags($row['content']), 0, 150)) . '...'; ?></p>

            <a href="<?php echo $base; ?>/posts/view_post.php?id=<?php echo $row['id']; ?>">👁 View</a> |
            <a href="?delete_post=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete this post?')">🗑 Delete</a> |
            <a href="?unreport=<?php echo $row['id']; ?>" onclick="return confirm('Mark as safe?')">✅ Mark Safe</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No reported posts 🎉</p>
<?php endif; ?>

<hr>
<h3>👥 User Management</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <?php while ($user = $users_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <?php if ($user['role'] !== 'admin'): ?>
                    <a href="?delete_user=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?')">🗑 Delete</a>
                <?php else: ?>
                    <em>Admin</em>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include '../includes/footer.php'; ?>
