<?php
include '../db_connection.php';

// Fetch doctors for selection (optional)
try {
    $doctors_stmt = $conn->query("SELECT doctor_id, full_name FROM local_doctor ORDER BY full_name");
    $doctors = $doctors_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching doctors: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "SELECT add_patient(:patient_number, :first_name, :last_name, :address, :telephone, :date_of_birth, :sex, :marital_status, :date_registered, :kin_full_name, :kin_relationship, :kin_address, :kin_telephone, :doctor_id)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':patient_number' => $_POST['patient_number'],
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':date_of_birth' => $_POST['date_of_birth'],
            ':sex' => $_POST['sex'],
            ':marital_status' => $_POST['marital_status'],
            ':date_registered' => $_POST['date_registered'],
            ':kin_full_name' => $_POST['kin_full_name'],
            ':kin_relationship' => $_POST['kin_relationship'],
            ':kin_address' => $_POST['kin_address'],
            ':kin_telephone' => $_POST['kin_telephone'],
            ':doctor_id' => $_POST['doctor_id'] ?: null
        ]);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die("Error adding patient: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Patient</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST">
        <h4>Patient Information</h4>
        <div class="row mb-3">
            <div class="col">
                <label>Patient Number</label>
                <input type="text" name="patient_number" class="form-control" required>
            </div>
            <div class="col">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Telephone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="col">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" required>
            </div>
            <div class="col">
                <label>Sex</label>
                <select name="sex" class="form-control" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Marital Status</label>
                <input type="text" name="marital_status" class="form-control">
            </div>
            <div class="col">
                <label>Date Registered</label>
                <input type="date" name="date_registered" class="form-control" required>
            </div>
        </div>

        <h4 class="mt-4">Next of Kin Information</h4>
        <div class="row mb-3">
            <div class="col">
                <label>Full Name</label>
                <input type="text" name="kin_full_name" class="form-control" required>
            </div>
            <div class="col">
                <label>Relationship</label>
                <input type="text" name="kin_relationship" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="kin_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Telephone</label>
            <input type="text" name="kin_telephone" class="form-control" required>
        </div>

        <h4 class="mt-4">Local Doctor (Optional)</h4>
        <div class="mb-3">
            <label>Choose Doctor</label>
            <select name="doctor_id" class="form-control">
                <option value="">-- None --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo htmlspecialchars($doctor['full_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Patient</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
