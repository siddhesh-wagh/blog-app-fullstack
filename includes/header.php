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
    <!-- Link to the stylesheets -->
    <link rel="stylesheet" href="<?php echo $base ? $base : ''; ?>/css/styles.css">

</head>
<body>


<!-- Header Section -->
<div class="header-wrapper">
    <header class="site-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="<?php echo $base; ?>/index.php" class="site-title">Blog-Post-Fullstack</a>
                </div>
                <ul class="nav-links">
                    <li><a href="<?php echo $base; ?>/index.php">🏠 Home</a></li>
                    <li><a href="<?php echo $base; ?>/blog.php">📰 Blogs</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo $base; ?>/dashboard.php">📋 Dashboard</a></li>
                        <li><a href="<?php echo $base; ?>/users/logout.php">🔒 Logout</a></li>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li><a href="<?php echo $base; ?>/admin/admin.php">🛠 Admin</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo $base; ?>/users/login.php">🔐 Login</a></li>
                        <li><a href="<?php echo $base; ?>/users/register.php">📝 Register</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo $base; ?>/contact.php">📩 Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
</div>

<!-- Main Content Starts -->
<div style="padding:20px;">
