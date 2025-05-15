<?php
include '../db_connection.php';

// Fetch all patients
$stmt = $conn->query("SELECT patient_number, first_name, last_name, address, telephone, date_of_birth, sex, marital_status FROM patient ORDER BY last_name, first_name");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Report - Wellmeadows Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Patient Report</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Patient Number</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Telephone</th>
                <th>Date of Birth</th>
                <th>Sex</th>
                <th>Marital Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['patient_number']) ?></td>
                    <td><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></td>
                    <td><?= htmlspecialchars($p['address']) ?></td>
                    <td><?= htmlspecialchars($p['telephone']) ?></td>
                    <td><?= htmlspecialchars($p['date_of_birth']) ?></td>
                    <td><?= htmlspecialchars($p['sex']) ?></td>
                    <td><?= htmlspecialchars($p['marital_status']) ?></td>
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
