<?php
// Include database connection
include '../db_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_number = $_POST['item_number'];
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $description = $_POST['description'];
    $quantity_in_stock = $_POST['quantity_in_stock'];
    $reorder_level = $_POST['reorder_level'];
    $cost_per_unit = $_POST['cost_per_unit'];

    try {
        $stmt = $conn->prepare("INSERT INTO supply_item (
            item_number, item_name, item_type, description,
            quantity_in_stock, reorder_level, cost_per_unit
        ) VALUES (
            :item_number, :item_name, :item_type, :description,
            :quantity_in_stock, :reorder_level, :cost_per_unit
        )");

        $stmt->execute([
            ':item_number' => $item_number,
            ':item_name' => $item_name,
            ':item_type' => $item_type,
            ':description' => $description,
            ':quantity_in_stock' => $quantity_in_stock,
            ':reorder_level' => $reorder_level,
            ':cost_per_unit' => $cost_per_unit
        ]);

        // Redirect back to items list
        header("Location: items.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding item: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Supply Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Add New Supply Item</h2>

    <div class="mb-3">
        <a href="items.php" class="btn btn-secondary">Back to Items List</a>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="item_number" class="form-label">Item Number</label>
            <input type="text" class="form-control" id="item_number" name="item_number" required>
        </div>

        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" required>
        </div>

        <div class="mb-3">
            <label for="item_type" class="form-label">Item Type</label>
            <select class="form-control" id="item_type" name="item_type" required>
                <option value="">Select Type</option>
                <option value="Surgical">Surgical</option>
                <option value="Non-surgical">Non-surgical</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="quantity_in_stock" class="form-label">Quantity In Stock</label>
            <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" required>
        </div>

        <div class="mb-3">
            <label for="reorder_level" class="form-label">Reorder Level</label>
            <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
        </div>

        <div class="mb-3">
            <label for="cost_per_unit" class="form-label">Cost Per Unit</label>
            <input type="number" step="0.01" class="form-control" id="cost_per_unit" name="cost_per_unit" required>
        </div>

        <button type="submit" class="btn btn-success">Add Supply Item</button>
    </form>
</div>

</body>
</html>
