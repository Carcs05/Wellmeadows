<?php
include '../db_connection.php';

// Fetch all requisitions
$stmt = $conn->query("SELECT r.*, w.ward_name, s.first_name || ' ' || s.last_name AS staff_name
                      FROM requisition r
                      JOIN ward w ON r.ward_id = w.ward_id
                      JOIN staff s ON r.staff_id = s.staff_id
                      ORDER BY r.requisition_date DESC");
$requisitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Requisitions Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Requisitions Management</h2>
    <a href="add_requisition.php" class="btn btn-primary mb-3">Add New Requisition</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Home</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Requisition No</th>
                <th>Ward</th>
                <th>Staff</th>
                <th>Requisition Date</th>
                <th>Delivery Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requisitions as $req): ?>
                <tr>
                    <td><?= htmlspecialchars($req['requisition_number']) ?></td>
                    <td><?= htmlspecialchars($req['ward_name']) ?></td>
                    <td><?= htmlspecialchars($req['staff_name']) ?></td>
                    <td><?= htmlspecialchars($req['requisition_date']) ?></td>
                    <td><?= htmlspecialchars($req['delivery_date']) ?></td>
                    <td>
                        <a href="edit_requisition.php?id=<?= $req['requisition_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_requisition.php?id=<?= $req['requisition_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this requisition?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
