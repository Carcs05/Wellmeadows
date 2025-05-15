<?php
// Include database connection
include '../db_connection.php';

// Get item ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: items.php");
    exit;
}

$item_id = $_GET['id'];

// Fetch current item data
try {
    $stmt = $conn->prepare("SELECT * FROM supply_item WHERE item_id = :id");
    $stmt->execute([':id' => $item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "Item not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching item: " . $e->getMessage();
    exit;
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_number = $_POST['item_number'];
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $description = $_POST['description'];
    $quantity_in_stock = $_POST['quantity_in_stock'];
    $reorder_level = $_POST['reorder_level'];
    $cost_per_unit = $_POST['cost_per_unit'];

    try {
        $stmt = $conn->prepare("UPDATE supply_item SET
            item_number = :item_number,
            item_name = :item_name,
            item_type = :item_type,
            description = :description,
            quantity_in_stock = :quantity_in_stock,
            reorder_level = :reorder_level,
            cost_per_unit = :cost_per_unit
            WHERE item_id = :id
        ");

        $stmt->execute([
            ':item_number' => $item_number,
            ':item_name' => $item_name,
            ':item_type' => $item_type,
            ':description' => $description,
            ':quantity_in_stock' => $quantity_in_stock,
            ':reorder_level' => $reorder_level,
            ':cost_per_unit' => $cost_per_unit,
            ':id' => $item_id
        ]);

        // Redirect back to items list
        header("Location: items.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating item: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supply Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Supply Item</h2>

    <div class="mb-3">
        <a href="items.php" class="btn btn-secondary">Back to Items List</a>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="item_number" class="form-label">Item Number</label>
            <input type="text" class="form-control" id="item_number" name="item_number" value="<?php echo htmlspecialchars($item['item_number']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="item_type" class="form-label">Item Type</label>
            <select class="form-control" id="item_type" name="item_type" required>
                <option value="Surgical" <?php echo ($item['item_type'] == 'Surgical') ? 'selected' : ''; ?>>Surgical</option>
                <option value="Non-surgical" <?php echo ($item['item_type'] == 'Non-surgical') ? 'selected' : ''; ?>>Non-surgical</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($item['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="quantity_in_stock" class="form-label">Quantity In Stock</label>
            <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="<?php echo htmlspecialchars($item['quantity_in_stock']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="reorder_level" class="form-label">Reorder Level</label>
            <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?php echo htmlspecialchars($item['reorder_level']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="cost_per_unit" class="form-label">Cost Per Unit</label>
            <input type="number" step="0.01" class="form-control" id="cost_per_unit" name="cost_per_unit" value="<?php echo htmlspecialchars($item['cost_per_unit']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Item</button>
    </form>
</div>

</body>
</html>
