<?php
// Include database connection
include '../db_connection.php';

// Fetch all wards
try {
    $stmt = $conn->prepare("SELECT * FROM ward ORDER BY ward_id ASC");
    $stmt->execute();
    $wards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching wards: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wards Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Wards Management</h2>
        <div>
            <a href="../index.php" class="btn btn-primary">Home</a>
            <a href="add_ward.php" class="btn btn-success">Add New Ward</a>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Ward Name</th>
                <th>Location</th>
                <th>Total Beds</th>
                <th>Telephone Extension</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($wards): ?>
                <?php foreach ($wards as $ward): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ward['ward_name']); ?></td>
                        <td><?php echo htmlspecialchars($ward['location']); ?></td>
                        <td><?php echo htmlspecialchars($ward['total_beds']); ?></td>
                        <td><?php echo htmlspecialchars($ward['telephone_extension']); ?></td>
                        <td>
                            <a href="edit_ward.php?id=<?php echo $ward['ward_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_ward.php?id=<?php echo $ward['ward_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ward?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No wards found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
