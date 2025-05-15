<?php
include '../db_connection.php';

// Fetch all supply items
$stmt_items = $conn->query("
    SELECT 
        item_number,
        item_name,
        item_type,
        quantity_in_stock,
        reorder_level,
        cost_per_unit
    FROM supply_item
    ORDER BY item_name
");
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

// Fetch all pharmaceutical drugs
$stmt_drugs = $conn->query("
    SELECT 
        drug_number,
        drug_name,
        quantity_in_stock,
        reorder_level,
        cost_per_unit
    FROM pharmaceutical
    ORDER BY drug_name
");
$drugs = $stmt_drugs->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplies Report - Wellmeadows Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Supplies Report - Items</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Item Number</th>
                <th>Item Name</th>
                <th>Item Type</th>
                <th>Quantity In Stock</th>
                <th>Reorder Level</th>
                <th>Cost Per Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i): ?>
                <tr>
                    <td><?= htmlspecialchars($i['item_number']) ?></td>
                    <td><?= htmlspecialchars($i['item_name']) ?></td>
                    <td><?= htmlspecialchars($i['item_type']) ?></td>
                    <td><?= htmlspecialchars($i['quantity_in_stock']) ?></td>
                    <td><?= htmlspecialchars($i['reorder_level']) ?></td>
                    <td>$<?= number_format($i['cost_per_unit'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Supplies Report - Drugs</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Drug Number</th>
                <th>Drug Name</th>
                <th>Quantity In Stock</th>
                <th>Reorder Level</th>
                <th>Cost Per Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($drugs as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['drug_number']) ?></td>
                    <td><?= htmlspecialchars($d['drug_name']) ?></td>
                    <td><?= htmlspecialchars($d['quantity_in_stock']) ?></td>
                    <td><?= htmlspecialchars($d['reorder_level']) ?></td>
                    <td>$<?= number_format($d['cost_per_unit'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">Home</a>
    </div>
</div>

</body>
</html>
