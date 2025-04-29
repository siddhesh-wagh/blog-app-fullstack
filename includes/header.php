<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog-Post-Fullstack</title>
    <link rel="stylesheet" href="/style.css"> <!-- (optional if you later add CSS) -->
</head>
<body>

<nav style="background:#333; padding:10px;">
    <a href="/index.php" style="color:white; margin-right:10px;">🏠 Home</a>
    <a href="/blog.php" style="color:white; margin-right:10px;">📰 Blogs</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/dashboard.php" style="color:white; margin-right:10px;">📋 Dashboard</a>
        <a href="/users/logout.php" style="color:white; margin-right:10px;">🔒 Logout</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/admin/admin.php" style="color:white;">🛠 Admin</a>
        <?php endif; ?>

    <?php else: ?>
        <a href="/users/login.php" style="color:white; margin-right:10px;">🔐 Login</a>
        <a href="/users/register.php" style="color:white; margin-right:10px;">📝 Register</a>
    <?php endif; ?>

    <a href="/contact.php" style="color:white; margin-left:10px;">📩 Contact</a>
</nav>

<div style="padding:20px;">
