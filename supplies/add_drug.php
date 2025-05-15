<?php
// Include database connection
include '../db_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_number = $_POST['drug_number'];
    $drug_name = $_POST['drug_name'];
    $description = $_POST['description'];
    $dosage = $_POST['dosage'];
    $method_of_administration = $_POST['method_of_administration'];
    $quantity_in_stock = $_POST['quantity_in_stock'];
    $reorder_level = $_POST['reorder_level'];
    $cost_per_unit = $_POST['cost_per_unit'];

    try {
        $stmt = $conn->prepare("INSERT INTO pharmaceutical 
            (drug_number, drug_name, description, dosage, method_of_administration, quantity_in_stock, reorder_level, cost_per_unit) 
            VALUES 
            (:drug_number, :drug_name, :description, :dosage, :method_of_administration, :quantity_in_stock, :reorder_level, :cost_per_unit)");

        $stmt->execute([
            ':drug_number' => $drug_number,
            ':drug_name' => $drug_name,
            ':description' => $description,
            ':dosage' => $dosage,
            ':method_of_administration' => $method_of_administration,
            ':quantity_in_stock' => $quantity_in_stock,
            ':reorder_level' => $reorder_level,
            ':cost_per_unit' => $cost_per_unit
        ]);

        // Redirect back to drugs list
        header("Location: drugs.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding drug: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Pharmaceutical Drug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Add New Pharmaceutical Drug</h2>
    <div class="mb-3">
        <a href="drugs.php" class="btn btn-secondary">Back to Drug List</a>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="drug_number" class="form-label">Drug Number</label>
            <input type="text" class="form-control" id="drug_number" name="drug_number" required>
        </div>

        <div class="mb-3">
            <label for="drug_name" class="form-label">Drug Name</label>
            <input type="text" class="form-control" id="drug_name" name="drug_name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="dosage" class="form-label">Dosage</label>
            <input type="text" class="form-control" id="dosage" name="dosage" required>
        </div>

        <div class="mb-3">
            <label for="method_of_administration" class="form-label">Method of Administration</label>
            <input type="text" class="form-control" id="method_of_administration" name="method_of_administration" required>
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

        <button type="submit" class="btn btn-success">Add Drug</button>
    </form>
</div>

</body>
</html>
