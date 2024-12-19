<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Submission</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</h1>
    <p>This is the user submission page. You can add your data here.</p>
</body>
</html>
