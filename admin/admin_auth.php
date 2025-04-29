<?php
include 'auth.php'; // ensure user logged in

// Check if user is admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: /index.php");
    exit;
}
