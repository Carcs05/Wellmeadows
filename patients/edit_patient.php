<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    die('Missing patient ID.');
}

$patient_id = $_GET['id'];

try {
    // Fetch patient details
    $stmt = $conn->prepare("SELECT * FROM patient WHERE patient_id = :id");
    $stmt->execute([':id' => $patient_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        die('Patient not found.');
    }

    // Fetch next of kin
    $stmt2 = $conn->prepare("SELECT * FROM next_of_kin WHERE patient_id = :id");
    $stmt2->execute([':id' => $patient_id]);
    $kin = $stmt2->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching patient: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update patient
        $stmt = $conn->prepare("SELECT update_patient(:patient_id, :address, :telephone, :marital_status)");
        $stmt->execute([
            ':patient_id' => $patient_id,
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':marital_status' => $_POST['marital_status']
        ]);

        // Update next of kin
        $stmt2 = $conn->prepare("SELECT update_next_of_kin(:patient_id, :full_name, :relationship, :address, :telephone)");
        $stmt2->execute([
            ':patient_id' => $patient_id,
            ':full_name' => $_POST['kin_full_name'],
            ':relationship' => $_POST['kin_relationship'],
            ':address' => $_POST['kin_address'],
            ':telephone' => $_POST['kin_telephone']
        ]);

        header('Location: index.php');
        exit();

    } catch (PDOException $e) {
        die("Error updating patient: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Patient</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST">
        <h4>Patient Information</h4>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Telephone</label>
                <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($patient['telephone']); ?>">
            </div>
            <div class="col">
                <label>Marital Status</label>
                <input type="text" name="marital_status" class="form-control" value="<?php echo htmlspecialchars($patient['marital_status']); ?>">
            </div>
        </div>

        <h4 class="mt-4">Next of Kin Information</h4>
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="kin_full_name" class="form-control" value="<?php echo htmlspecialchars($kin['full_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Relationship</label>
            <input type="text" name="kin_relationship" class="form-control" value="<?php echo htmlspecialchars($kin['relationship'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="kin_address" class="form-control" required><?php echo htmlspecialchars($kin['address'] ?? ''); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Telephone</label>
            <input type="text" name="kin_telephone" class="form-control" value="<?php echo htmlspecialchars($kin['telephone'] ?? ''); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Patient</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
