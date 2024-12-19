<?php
// Database connection
function getDbConnection() {
    $conn = new mysqli("localhost", "root", "", "approval_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
