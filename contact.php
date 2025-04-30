<?php
include 'includes/header.php';
include 'includes/db.php';

$name    = '';
$email   = '';
$message = '';
$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = "Name is required.";
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if ($message === '') {
        $errors[] = "Message cannot be empty.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = true;
            $name = $email = $message = '';
        } else {
            $errors[] = "Failed to send your message. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<div class="page-contact content">
    <h2>📩 Contact Us</h2>

    <?php if ($success): ?>
        <p class="success-message">Thank you, <?php echo htmlspecialchars($_POST['name']); ?>! Your message has been received.</p>
    <?php else: ?>
        <?php if ($errors): ?>
            <ul class="error-messages">
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="contact.php" class="contact-form">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label>Message:</label>
            <textarea name="message" rows="6" required><?php echo htmlspecialchars($message); ?></textarea>

            <button type="submit">Send</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
