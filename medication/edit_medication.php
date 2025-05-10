<?php
// Include database connection
include '../db_connection.php';

// Check if medication ID is set
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$medication_id = $_GET['id'];

// Fetch medication details
try {
    $stmt = $conn->prepare("
        SELECT m.*, 
               p.first_name || ' ' || p.last_name AS patient_name,
               ph.drug_name
        FROM medication m
        JOIN patient p ON m.patient_id = p.patient_id
        JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
        WHERE m.medication_id = :medication_id
    ");
    $stmt->execute([':medication_id' => $medication_id]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medication) {
        echo "Medication record not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching medication: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $units_per_day = $_POST['units_per_day'];
    $method_of_administration = $_POST['method_of_administration'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];

    try {
        $stmt = $conn->prepare("
            UPDATE medication
            SET units_per_day = :units_per_day,
                method_of_administration = :method_of_administration,
                start_date = :start_date,
                finish_date = :finish_date
            WHERE medication_id = :medication_id
        ");
        $stmt->execute([
            ':units_per_day' => $units_per_day,
            ':method_of_administration' => $method_of_administration,
            ':start_date' => $start_date,
            ':finish_date' => $finish_date,
            ':medication_id' => $medication_id
        ]);

        // Redirect back after update
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating medication: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Medication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Medication</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Patient Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($medication['patient_name']); ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Drug Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($medication['drug_name']); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="units_per_day" class="form-label">Units per Day</label>
            <input type="number" name="units_per_day" id="units_per_day" class="form-control" value="<?php echo htmlspecialchars($medication['units_per_day']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="method_of_administration" class="form-label">Method of Administration</label>
            <input type="text" name="method_of_administration" id="method_of_administration" class="form-control" value="<?php echo htmlspecialchars($medication['method_of_administration']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($medication['start_date']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="finish_date" class="form-label">Finish Date</label>
            <input type="date" name="finish_date" id="finish_date" class="form-control" value="<?php echo htmlspecialchars($medication['finish_date']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Medication</button>
    </form>

</div>
</body>
</html>
