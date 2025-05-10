<?php
include '../db_connection.php';

try {
    $stmt = $conn->query("SELECT * FROM patient ORDER BY last_name, first_name");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching patients: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Patient Management</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <div class="mb-4">
        <a href="add_patient.php" class="btn btn-success">Add New Patient</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Patient Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Telephone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['patient_number']); ?></td>
                    <td><?php echo htmlspecialchars($patient['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($patient['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($patient['telephone']); ?></td>
                    <td>
                        <a href="edit_patient.php?id=<?php echo $patient['patient_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_patient.php?id=<?php echo $patient['patient_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
