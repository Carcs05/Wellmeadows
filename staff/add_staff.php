<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "SELECT add_staff(:staff_number, :first_name, :last_name, :address, :telephone, :date_of_birth, :sex, :nin, :position, :current_salary, :salary_scale, :payment_type, :contract_type, :hours_per_week)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':staff_number' => $_POST['staff_number'],
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':date_of_birth' => $_POST['date_of_birth'],
            ':sex' => $_POST['sex'],
            ':nin' => $_POST['nin'],
            ':position' => $_POST['position'],
            ':current_salary' => $_POST['current_salary'],
            ':salary_scale' => $_POST['salary_scale'],
            ':payment_type' => $_POST['payment_type'],
            ':contract_type' => $_POST['contract_type'],
            ':hours_per_week' => $_POST['hours_per_week']
        ]);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die("Error adding staff: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Staff</h2>
    <a href="../index.php" class="btn btn-primary">Home</a>
</div>
    <form method="POST">
        <div class="row mb-3">
            <div class="col">
                <label>Staff Number</label>
                <input type="text" name="staff_number" class="form-control" required>
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
            <textarea name="address" class="form-control" rows="2" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Telephone</label>
                <input type="text" name="telephone" class="form-control" required>
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
                <label>NIN</label>
                <input type="text" name="nin" class="form-control" required>
            </div>
            <div class="col">
                <label>Position</label>
                <input type="text" name="position" class="form-control" required>
            </div>
            <div class="col">
                <label>Current Salary</label>
                <input type="number" step="0.01" name="current_salary" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Salary Scale</label>
                <input type="text" name="salary_scale" class="form-control" required>
            </div>
            <div class="col">
                <label>Payment Type</label>
                <select name="payment_type" class="form-control" required>
                    <option value="W">Weekly</option>
                    <option value="M">Monthly</option>
                </select>
            </div>
            <div class="col">
                <label>Contract Type</label>
                <select name="contract_type" class="form-control" required>
                    <option value="P">Permanent</option>
                    <option value="T">Temporary</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Hours Per Week</label>
            <input type="number" step="0.01" name="hours_per_week" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Staff</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
