<?php
// Include database connection
include '../db_connection.php';

// Fetch supply items
try {
    $stmt = $conn->prepare("SELECT * FROM supply_item ORDER BY item_name ASC");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching items: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supply Items Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Supply Items Management (Surgical/Non-Surgical)</h2>

    <div class="mb-3">
        <a href="add_item.php" class="btn btn-primary">Add New Supply Item</a>
        <a href="../index.php" class="btn btn-secondary">Home</a>
    </div>

    <?php if (!empty($items)): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Item Number</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Description</th>
                    <th>Quantity In Stock</th>
                    <th>Reorder Level</th>
                    <th>Cost Per Unit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item_number']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_type']); ?></td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity_in_stock']); ?></td>
                    <td><?php echo htmlspecialchars($item['reorder_level']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($item['cost_per_unit'], 2)); ?></td>
                    <td>
                        <a href="edit_item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No supply items found.</p>
    <?php endif; ?>

</div>

</body>
</html>
