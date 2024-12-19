<?php
session_start();
include '../classes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_username'] = $user['username'];
            header("Location: user_submit.php");
            exit;
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h1>User Login</h1>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Log In</button>
    </form>
    <p>Don't have an account? <a href="user_signup.php">Sign Up</a></p>
</body>
</html>
