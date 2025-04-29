<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['post_id'])) {
    header("Location: ../blog.php");
    exit;
}

$post_id = intval($_GET['post_id']);
$user_id = $_SESSION['user_id'];

// Optional: prevent multiple reports
$stmt = $conn->prepare("SELECT id FROM reports WHERE post_id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Insert report
    $reason = "Reported by user."; // can later extend with a form
    $insert = $conn->prepare("INSERT INTO reports (post_id, user_id, reason) VALUES (?, ?, ?)");
    $insert->bind_param("iis", $post_id, $user_id, $reason);
    $insert->execute();

    // Optional: Auto-mark post as reported (admin will later moderate)
    $conn->query("UPDATE posts SET reported = 1 WHERE id = $post_id");
}

header("Location: ../blog.php");
exit;
