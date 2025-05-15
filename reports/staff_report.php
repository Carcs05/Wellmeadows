<?php
include '../db_connection.php';

// Fetch all staff
$stmt = $conn->query("SELECT staff_number, first_name, last_name, position, current_salary, salary_scale FROM staff ORDER BY last_name, first_name");
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Report - Wellmeadows Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Staff Report</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Staff Number</th>
                <th>Full Name</th>
                <th>Position</th>
                <th>Current Salary</th>
                <th>Salary Scale</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['staff_number']) ?></td>
                    <td><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></td>
                    <td><?= htmlspecialchars($s['position']) ?></td>
                    <td><?= number_format($s['current_salary'], 2) ?></td>
                    <td><?= htmlspecialchars($s['salary_scale']) ?></td>
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
