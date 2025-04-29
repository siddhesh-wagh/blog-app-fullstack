<?php
include 'includes/header.php';
include 'includes/db.php';

$name    = '';
$email   = '';
$message = '';
$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim and collect POST data
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = "Name is required.";
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if ($message === '') {
        $errors[] = "Message cannot be empty.";
    }

    // If no errors, insert into contacts table
    if (empty($errors)) {
        $stmt = $conn->prepare("
            INSERT INTO contacts (name, email, message)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = true;
            // Clear form values
            $name = $email = $message = '';
        } else {
            $errors[] = "Failed to send your message. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<h2>📩 Contact Us</h2>

<?php if ($success): ?>
    <p style="color:green;">Thank you, <?php echo htmlspecialchars($_POST['name']); ?>! Your message has been received.</p>
<?php else: ?>
    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="contact.php">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="6" cols="60" required><?php echo htmlspecialchars($message); ?></textarea><br><br>

        <button type="submit">Send</button>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
