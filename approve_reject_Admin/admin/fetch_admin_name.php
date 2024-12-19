<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Submission</title>
</head>
<body>
    <h1>Welcome,Admin <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
    
</body>
</html>