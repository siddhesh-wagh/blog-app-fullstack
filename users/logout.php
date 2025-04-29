<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
exit;

include '../includes/header.php';  // Include header
?>

<h2>You have been logged out successfully.</h2>
<p><a href="../index.php">Go to Home</a></p>

<?php include '../includes/footer.php';  // Include footer ?>
