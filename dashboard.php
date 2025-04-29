<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: users/login.php");
    exit;
}

include 'includes/db.php';

// Handle delete
if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    $user_id = $_SESSION['user_id'];
    $conn->query("DELETE FROM posts WHERE id = $post_id AND user_id = $user_id");
}

// Get current user's posts
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC");

include 'includes/header.php';  // Include header

?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<a href="posts/add_post.php">➕ Create New Post</a> |
<a href="users/logout.php">🔒 Logout</a>

<h3>Your Posts</h3>
<?php while ($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
        <p><?php echo substr(strip_tags($row['content']), 0, 100) . '...'; ?></p>
        <a href="posts/view_post.php?id=<?php echo $row['id']; ?>">👁 View</a>
        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">🗑 Delete</a>
    </div>
<?php endwhile; ?>

<?php include 'includes/footer.php';  // Include footer ?>
