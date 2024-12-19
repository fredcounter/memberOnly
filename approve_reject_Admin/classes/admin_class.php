<?php
include 'db.php';

function getPendingSubmissions() {
    $conn = getDbConnection();
    $result = $conn->query("SELECT * FROM user_data WHERE status='pending'");
    $conn->close();
    return $result;
}

function updateSubmissionStatus($id, $status) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("UPDATE user_data SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}
?>
