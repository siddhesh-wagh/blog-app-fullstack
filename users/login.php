<?php
include '../includes/db.php';
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $role);
    
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: ../dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid password.";
        }
    } else {
        $errors[] = "No user found.";
    }
    $stmt->close();
}

include '../includes/header.php';  // Include header
?>

<h2>Login</h2>
<form method="POST" action="">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>

<?php
if (!empty($errors)) {
    foreach ($errors as $err) {
        echo "<p style='color:red;'>$err</p>";
    }
}

include '../includes/footer.php';  // Include footer
?>
