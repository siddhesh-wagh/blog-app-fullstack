<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // or your MySQL password
$db = 'blog_post_fullstack';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
