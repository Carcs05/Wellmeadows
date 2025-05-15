<?php
include '../db_connection.php';

// Fetch wards and staff for dropdowns
$wards = $conn->query("SELECT * FROM ward ORDER BY ward_name")->fetchAll(PDO::FETCH_ASSOC);
$staff = $conn->query("SELECT * FROM staff ORDER BY last_name, first_name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requisition_number = $_POST['requisition_number'];
    $ward_id = $_POST['ward_id'];
    $staff_id = $_POST['staff_id'];
    $requisition_date = $_POST['requisition_date'];

    $sql = "INSERT INTO requisition (requisition_number, ward_id, staff_id, requisition_date)
            VALUES (:requisition_number, :ward_id, :staff_id, :requisition_date)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        ':requisition_number' => $requisition_number,
        ':ward_id' => $ward_id,
        ':staff_id' => $staff_id,
        ':requisition_date' => $requisition_date
    ]);

    if ($result) {
        echo "<script>alert('Requisition added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error adding requisition.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Requisition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Requisition</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Requisition Number</label>
            <input type="text" name="requisition_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Ward</label>
            <select name="ward_id" class="form-control" required>
                <option value="">Select Ward</option>
                <?php foreach ($wards as $ward): ?>
                    <option value="<?= $ward['ward_id'] ?>"><?= htmlspecialchars($ward['ward_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Select Staff</label>
            <select name="staff_id" class="form-control" required>
                <option value="">Select Staff</option>
                <?php foreach ($staff as $s): ?>
                    <option value="<?= $s['staff_id'] ?>"><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Requisition Date</label>
            <input type="date" name="requisition_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Requisition</button>
        <a href="index.php" class="btn btn-secondary">Home</a>
    </form>
</div>
</body>
</html>
