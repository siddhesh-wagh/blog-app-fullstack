<?php
// 1) Gate access
include $_SERVER['DOCUMENT_ROOT'].'/blog-app-fullstack/includes/admin_auth.php';

// 2) Database connection
include '../includes/db.php';

// 3) Shared header (with admin link)
include '../includes/header.php';

// 4) Handle actions
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    header("Location: admin.php"); exit;
}
if (isset($_GET['unreport'])) {
    $stmt = $conn->prepare("UPDATE posts SET reported = 0 WHERE id = ?");
    $stmt->bind_param("i", $_GET['unreport']);
    $stmt->execute();
    header("Location: admin.php"); exit;
}

// 5) Fetch data
$users    = $conn->query("
  SELECT u.id, u.username, COUNT(p.id) AS post_count
  FROM users u
  LEFT JOIN posts p ON u.id = p.user_id
  GROUP BY u.id
");
$reports  = $conn->query("
  SELECT p.*, u.username 
  FROM posts p 
  JOIN users u ON p.user_id = u.id 
  WHERE p.reported = 1
");
$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<h2>🛠 Admin Dashboard</h2>

<hr>
<h3>👥 Users (with post counts)</h3>
<?php if ($users->num_rows): ?>
  <table border="1" cellpadding="5">
    <tr><th>ID</th><th>Username</th><th># Posts</th></tr>
    <?php while($u = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= $u['post_count'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p>No users found.</p>
<?php endif; ?>

<hr>
<h3>🚨 Reported Posts</h3>
<?php if ($reports->num_rows): ?>
  <?php while($r = $reports->fetch_assoc()): ?>
    <div style="border:1px solid red;padding:10px;margin-bottom:10px;">
      <strong><?= htmlspecialchars($r['title']) ?></strong><br>
      By <?= htmlspecialchars($r['username']) ?> on <?= date('M d, Y',strtotime($r['created_at'])) ?><br>
      <?= substr(strip_tags($r['content']),0,150).'...' ?><br>
      <a href="../posts/view_post.php?id=<?= $r['id'] ?>">View</a>
      | <a href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
      | <a href="?unreport=<?= $r['id'] ?>" onclick="return confirm('Mark safe?')">Unreport</a>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No reported posts.</p>
<?php endif; ?>

<hr>
<h3>📥 Contact Messages</h3>
<?php if ($contacts->num_rows): ?>
  <?php while($c = $contacts->fetch_assoc()): 
      // safely handle missing columns
      $cn = htmlspecialchars($c['name']    ?? '—');
      $ce = htmlspecialchars($c['email']   ?? '');
      $cm = nl2br(htmlspecialchars($c['message'] ?? ''));
      $ct = isset($c['created_at'])
            ? date('M d, Y H:i', strtotime($c['created_at']))
            : '';
  ?>
    <div style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
      <strong><?= $cn ?> (<?= $ce ?>)</strong><br>
      <?= $cm ?><br>
      <small><?= $ct ?></small>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No contact messages.</p>
<?php endif; ?>

<hr>
<h3>Total Users: <?= $users->num_rows ?></h3>

<?php
// 6) Shared footer
include '../includes/footer.php';
