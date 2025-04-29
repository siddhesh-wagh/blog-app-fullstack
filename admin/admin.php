<?php
// 1) Gate access
include $_SERVER['DOCUMENT_ROOT'].'/blog-app-fullstack/includes/admin_auth.php';

// 2) Database connection
include '../includes/db.php';

// 3) Shared header
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
if (isset($_GET['approve_admin'])) {
    $stmt = $conn->prepare("UPDATE users SET role = 'admin', admin_requested = 0 WHERE id = ?");
    $stmt->bind_param("i", $_GET['approve_admin']);
    $stmt->execute();
    header("Location: admin.php"); exit;
}
if (isset($_GET['deny_admin'])) {
    $stmt = $conn->prepare("UPDATE users SET admin_requested = 0 WHERE id = ?");
    $stmt->bind_param("i", $_GET['deny_admin']);
    $stmt->execute();
    header("Location: admin.php"); exit;
}

// 5) Fetch data
$users = $conn->query("SELECT u.id, u.username, COUNT(p.id) AS post_count FROM users u LEFT JOIN posts p ON u.id = p.user_id GROUP BY u.id");
$reports = $conn->query("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.reported = 1");
$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
$admin_requests = $conn->query("SELECT id, username FROM users WHERE admin_requested = 1");
?>

<h2>🛠 Admin Dashboard</h2>

<!-- Tab Navigation -->
<div class="tab-buttons">
  <button onclick="showTab('users')">👥 Users</button>
  <button onclick="showTab('reports')">🚨 Reports</button>
  <button onclick="showTab('contacts')">📥 Contacts</button>
  <button onclick="showTab('admin_requests')">🛡 Admin Requests</button>
</div>

<!-- Styles -->
<style>
  .tab { display: none; }
  .tab.active { display: block; margin-top: 20px; }
  .tab-buttons button {
    padding: 10px 20px;
    margin-right: 8px;
    border: 1px solid #ccc;
    background: #eee;
    cursor: pointer;
    border-radius: 5px;
  }
</style>

<!-- JavaScript -->
<script>
  function showTab(id) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById(id).classList.add('active');
  }
  window.onload = () => showTab('users'); // Default tab
</script>

<!-- Tabs -->
<div id="users" class="tab">
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
</div>

<div id="reports" class="tab">
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
</div>

<div id="contacts" class="tab">
  <h3>📥 Contact Messages</h3>
  <?php if ($contacts->num_rows): ?>
    <?php while($c = $contacts->fetch_assoc()):
      $cn = htmlspecialchars($c['name'] ?? '—');
      $ce = htmlspecialchars($c['email'] ?? '');
      $cm = nl2br(htmlspecialchars($c['message'] ?? ''));
      $ct = isset($c['created_at']) ? date('M d, Y H:i', strtotime($c['created_at'])) : '';
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
</div>

<div id="admin_requests" class="tab">
  <h3>🛡 Admin Access Requests</h3>
  <?php if ($admin_requests->num_rows): ?>
    <ul>
      <?php while ($row = $admin_requests->fetch_assoc()): ?>
        <li>
          <?= htmlspecialchars($row['username']) ?>
          <a href="?approve_admin=<?= $row['id'] ?>" onclick="return confirm('Grant admin access?')">✅ Approve</a>
          <a href="?deny_admin=<?= $row['id'] ?>" onclick="return confirm('Deny request?')">❌ Deny</a>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p>No pending admin requests.</p>
  <?php endif; ?>
</div>

<p><strong>Total Users: <?= $users->num_rows ?></strong></p>

<?php include '../includes/footer.php'; ?>
