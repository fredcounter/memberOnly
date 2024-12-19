<?php
include '../classes/admin_class.php';

// Fetch all approved data
function getApprovedData() {
    $conn = getDbConnection();
    $result = $conn->query("SELECT * FROM user_data WHERE status='approved'");
    $conn->close();
    return $result;
}

$approvedData = getApprovedData();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Data</title>
</head>
<body>
    <h1>Approved Data</h1>
    <?php if ($approvedData->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Data</th>
                <th>Approved At</th>
            </tr>
            <?php while ($row = $approvedData->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No approved data available.</p>
    <?php endif; ?>
</body>
</html>
<?