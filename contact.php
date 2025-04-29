<?php include 'includes/header.php'; ?>

<h2>📩 Contact Us</h2>

<form method="POST" action="contact.php">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Message:<br>
    <textarea name="message" rows="6" cols="60" required></textarea><br><br>
    <button type="submit">Send</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p style='color:green;'>Thank you for contacting us, " . htmlspecialchars($_POST['name']) . "!</p>";
    // (Later you can save it in DB or send email)
}
?>

<?php include 'includes/footer.php'; ?>
