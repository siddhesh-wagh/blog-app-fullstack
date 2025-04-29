<?php
session_start();
?>

<h1>Welcome to Blog-Post-Fullstack!</h1>

<p>This is a simple blog platform where you can create, share, and explore blogs. 
You need to <b>Register</b> and <b>Login</b> to post or report content.</p>

<hr>

<nav>
    <a href="index.php">🏠 Home</a> |
    <a href="blog.php">📰 View Blogs</a> |
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">📋 Dashboard</a> |
        <a href="users/logout.php">🔒 Logout</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            | <a href="admin/admin.php">🛠 Admin Panel</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="users/login.php">🔐 Login</a> |
        <a href="users/register.php">📝 Register</a>
    <?php endif; ?>
</nav>

<hr>

<h2>Latest News</h2>
<ul>
    <li>Create your own blogs easily 📝</li>
    <li>Report inappropriate blogs ⚠️</li>
    <li>Admin manages the platform 🔧</li>
</ul>

<hr>

<footer>
    <p>© <?php echo date('Y'); ?> Blog-Post-Fullstack. All rights reserved.</p>
</footer>
