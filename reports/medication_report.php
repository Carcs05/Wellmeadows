<?php
include '../db_connection.php';

// Fetch all medication records
$stmt = $conn->query("
    SELECT 
        p.patient_number,
        p.first_name,
        p.last_name,
        ph.drug_name,
        m.units_per_day,
        m.method_of_administration,
        m.start_date,
        m.finish_date
    FROM medication m
    JOIN patient p ON m.patient_id = p.patient_id
    JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
    ORDER BY p.last_name, p.first_name, m.start_date DESC
");
$medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medication Report - Wellmeadows Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Medication Report</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Patient Number</th>
                <th>Patient Name</th>
                <th>Drug Name</th>
                <th>Units Per Day</th>
                <th>Method of Administration</th>
                <th>Start Date</th>
                <th>Finish Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medications as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['patient_number']) ?></td>
                    <td><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></td>
                    <td><?= htmlspecialchars($m['drug_name']) ?></td>
                    <td><?= htmlspecialchars($m['units_per_day']) ?></td>
                    <td><?= htmlspecialchars($m['method_of_administration']) ?></td>
                    <td><?= htmlspecialchars($m['start_date']) ?></td>
                    <td><?= htmlspecialchars($m['finish_date']) ?></td>
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
