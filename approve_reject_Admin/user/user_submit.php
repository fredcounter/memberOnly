<?php
include 'fetch_users_name.php';
include '../classes/user_class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['name'];
    $user_data = $_POST['data'];

    if (submitUserData($user_name, $user_data)) {
        echo "Your data has been submitted and is awaiting admin approval.........";
    } else {
        echo "Error: Unable to submit your data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Data</title>
</head>
<body>
    <h1>Submit Your Data</h1>
    <form method="POST">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label for="data">Data:</label><br>
        <textarea name="data" required></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
