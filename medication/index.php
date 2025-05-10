<?php
// Include database connection
include '../db_connection.php';

// Fetch all medication records
try {
    $stmt = $conn->prepare("
        SELECT m.medication_id, 
               p.first_name || ' ' || p.last_name AS patient_name,
               ph.drug_name,
               m.method_of_administration,
               m.units_per_day,
               m.start_date,
               m.finish_date
        FROM medication m
        JOIN patient p ON m.patient_id = p.patient_id
        JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
        ORDER BY m.start_date DESC
    ");
    $stmt->execute();
    $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching medications: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medication Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Medication Management</h2>
        <div>
            <a href="../index.php" class="btn btn-primary">Home</a>
            <a href="add_medication.php" class="btn btn-success">Add Medication</a>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Patient Name</th>
                <th>Drug Name</th>
                <th>Method of Administration</th>
                <th>Units Per Day</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($medications): ?>
                <?php foreach ($medications as $medication): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medication['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($medication['drug_name']); ?></td>
                        <td><?php echo htmlspecialchars($medication['method_of_administration']); ?></td>
                        <td><?php echo htmlspecialchars($medication['units_per_day']); ?></td>
                        <td><?php echo htmlspecialchars($medication['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($medication['finish_date']); ?></td>
                        <td>
                            <a href="edit_medication.php?id=<?php echo $medication['medication_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_medication.php?id=<?php echo $medication['medication_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this medication?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No medications found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
