<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$base = '/blog-app-fullstack'; // This must match your browser URL
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog-Post-Fullstack</title>
    <link rel="stylesheet" href="<?php echo $base; ?>/style.css">
</head>
<body>

<nav style="background:#333; padding:10px;">
    <a href="<?php echo $base; ?>/index.php" style="color:white; margin-right:10px;">🏠 Home</a>
    <a href="<?php echo $base; ?>/blog.php" style="color:white; margin-right:10px;">📰 Blogs</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base; ?>/dashboard.php" style="color:white; margin-right:10px;">📋 Dashboard</a>
        <a href="<?php echo $base; ?>/users/logout.php" style="color:white; margin-right:10px;">🔒 Logout</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="<?php echo $base; ?>/admin/admin.php" style="color:white;">🛠 Admin</a>
        <?php endif; ?>

    <?php else: ?>
        <a href="<?php echo $base; ?>/users/login.php" style="color:white; margin-right:10px;">🔐 Login</a>
        <a href="<?php echo $base; ?>/users/register.php" style="color:white; margin-right:10px;">📝 Register</a>
    <?php endif; ?>

    <a href="<?php echo $base; ?>/contact.php" style="color:white; margin-left:10px;">📩 Contact</a>
</nav>

<div style="padding:20px;">
