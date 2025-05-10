<?php
// Include database connection
include '../db_connection.php';

// Fetch patients
try {
    $stmt = $conn->query("SELECT patient_id, first_name || ' ' || last_name AS full_name FROM patient ORDER BY last_name");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching patients: " . $e->getMessage();
    exit;
}

// Fetch drugs
try {
    $stmt = $conn->query("SELECT drug_id, drug_name FROM pharmaceutical ORDER BY drug_name");
    $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching drugs: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $drug_id = $_POST['drug_id'];
    $units_per_day = $_POST['units_per_day'];
    $method_of_administration = $_POST['method_of_administration'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO medication (patient_id, drug_id, units_per_day, method_of_administration, start_date, finish_date)
            VALUES (:patient_id, :drug_id, :units_per_day, :method_of_administration, :start_date, :finish_date)
        ");
        $stmt->execute([
            ':patient_id' => $patient_id,
            ':drug_id' => $drug_id,
            ':units_per_day' => $units_per_day,
            ':method_of_administration' => $method_of_administration,
            ':start_date' => $start_date,
            ':finish_date' => $finish_date
        ]);

        // Redirect after adding
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding medication: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Medication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Medication</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="">Select Patient</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo $patient['patient_id']; ?>">
                        <?php echo htmlspecialchars($patient['full_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="drug_id" class="form-label">Drug</label>
            <select name="drug_id" id="drug_id" class="form-select" required>
                <option value="">Select Drug</option>
                <?php foreach ($drugs as $drug): ?>
                    <option value="<?php echo $drug['drug_id']; ?>">
                        <?php echo htmlspecialchars($drug['drug_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="units_per_day" class="form-label">Units per Day</label>
            <input type="number" name="units_per_day" id="units_per_day" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="method_of_administration" class="form-label">Method of Administration</label>
            <input type="text" name="method_of_administration" id="method_of_administration" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="finish_date" class="form-label">Finish Date</label>
            <input type="date" name="finish_date" id="finish_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Medication</button>
    </form>

</div>
</body>
</html>
