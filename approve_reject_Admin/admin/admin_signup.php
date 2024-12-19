<?php
include '../classes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $conn = getDbConnection();

        try {
            $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                header('Location: admin_login.php');
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { 
                $error_message = "Error: Unable to create admin account. Username might already exist.";
            } else {
                $error_message = "An unexpected error occurred. Please try again later.";
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Sign-Up</title>
</head>
<body>
    <h1>Admin Sign-Up</h1>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="admin_login.php">Log In</a></p>
</body>
</html>
