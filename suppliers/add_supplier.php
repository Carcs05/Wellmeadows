<?php
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_number = $_POST['supplier_number'];
    $supplier_name = $_POST['supplier_name'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $fax = $_POST['fax'];

    $sql = "INSERT INTO supplier (supplier_number, supplier_name, address, telephone, fax)
            VALUES (:supplier_number, :supplier_name, :address, :telephone, :fax)";

    $stmt = $conn->prepare($sql);

    $result = $stmt->execute([
        ':supplier_number' => $supplier_number,
        ':supplier_name' => $supplier_name,
        ':address' => $address,
        ':telephone' => $telephone,
        ':fax' => $fax
    ]);

    if ($result) {
        echo "<script>alert('Supplier added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error adding supplier.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Supplier</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Supplier Number</label>
            <input type="text" name="supplier_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Telephone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fax</label>
            <input type="text" name="fax" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Supplier</button>
        <a href="index.php" class="btn btn-secondary">Home</a>
    </form>
</div>
</body>
</html>
