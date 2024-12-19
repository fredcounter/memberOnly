<?php
include 'db.php';
function submitUserData($name, $data) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("INSERT INTO user_data (name, data, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ss", $name, $data);

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}
?>
