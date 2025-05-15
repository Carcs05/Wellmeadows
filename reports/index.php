<?php
include '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports - Wellmeadows Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Reports</h2>

    <div class="list-group mt-4">
        <a href="staff_report.php" class="list-group-item list-group-item-action">Staff Report</a>
        <a href="patient_report.php" class="list-group-item list-group-item-action">Patient Report</a>
        <a href="medication_report.php" class="list-group-item list-group-item-action">Medication Report</a>
        <a href="supplies_report.php" class="list-group-item list-group-item-action">Supplies Report</a>
    </div>

    <div class="mt-4">
        <a href="../index.php" class="btn btn-secondary">Home</a>
    </div>
</div>

</body>
</html>
