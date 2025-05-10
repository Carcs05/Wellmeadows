<?php
include '../db_connection.php';

// Fetch all staff
try {
    $stmt = $conn->query("SELECT * FROM staff ORDER BY last_name, first_name");
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching staff: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Staff Management</h2>
    <a href="../index.php" class="btn btn-primary">Home</a>
</div>
    <a href="add_staff.php" class="btn btn-primary mb-3">Add New Staff</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Staff Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Telephone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffs as $staff): ?>
                <tr>
                    <td><?php echo htmlspecialchars($staff['staff_number']); ?></td>
                    <td><?php echo htmlspecialchars($staff['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($staff['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($staff['position']); ?></td>
                    <td><?php echo htmlspecialchars($staff['telephone']); ?></td>
                    <td>
                        <a href="edit_staff.php?id=<?php echo $staff['staff_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_staff.php?id=<?php echo $staff['staff_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

