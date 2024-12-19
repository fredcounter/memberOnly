<?php
require_once '../admin/fetch_admin_name.php';
include '../classes/admin_class.php';


if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    $status = ($action === 'approve') ? 'approved' : 'rejected';

    if (updateSubmissionStatus($id, $status)) {
        echo "Action successfully applied.<br>";
    } else {
        echo "Error: Unable to apply action.<br>";
    }
}


$pendingSubmissions = getPendingSubmissions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Approval</title>
</head>
<body>
    <h1>Pending Submissions</h1>
    <?php if ($pendingSubmissions->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Data</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $pendingSubmissions->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td>
                        <a href="?action=approve&id=<?php echo $row['id']; ?>">Approve</a> | 
                        <a href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending submissions.</p>
    <?php endif; ?>
</body>
</html>
