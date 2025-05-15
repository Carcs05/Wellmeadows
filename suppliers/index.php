<?php
// Include database connection
include '../db_connection.php';

// Fetch all suppliers
try {
    $stmt = $conn->query("SELECT * FROM supplier ORDER BY supplier_name ASC");
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching suppliers: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Suppliers</h2>

    <div class="mb-3">
        <a href="add_supplier.php" class="btn btn-success">Add New Supplier</a>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <?php if (count($suppliers) > 0): ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Supplier Number</th>
                    <th>Supplier Name</th>
                    <th>Address</th>
                    <th>Telephone</th>
                    <th>Fax</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['supplier_number']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['address']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['fax']); ?></td>
                        <td>
                            <a href="edit_supplier.php?id=<?php echo $supplier['supplier_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_supplier.php?id=<?php echo $supplier['supplier_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No suppliers found.</p>
    <?php endif; ?>

</div>

</body>
</html>
