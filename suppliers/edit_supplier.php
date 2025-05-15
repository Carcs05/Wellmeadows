<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    echo "Supplier ID is missing!";
    exit;
}

$supplier_id = $_GET['id'];

// Fetch existing supplier data
$stmt = $conn->prepare("SELECT * FROM supplier WHERE supplier_id = :supplier_id");
$stmt->execute([':supplier_id' => $supplier_id]);
$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$supplier) {
    echo "Supplier not found!";
    exit;
}

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_number = $_POST['supplier_number'];
    $supplier_name = $_POST['supplier_name'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $fax = $_POST['fax'];

    $update = "UPDATE supplier
               SET supplier_number = :supplier_number,
                   supplier_name = :supplier_name,
                   address = :address,
                   telephone = :telephone,
                   fax = :fax
               WHERE supplier_id = :supplier_id";

    $stmt = $conn->prepare($update);

    $result = $stmt->execute([
        ':supplier_number' => $supplier_number,
        ':supplier_name' => $supplier_name,
        ':address' => $address,
        ':telephone' => $telephone,
        ':fax' => $fax,
        ':supplier_id' => $supplier_id
    ]);

    if ($result) {
        echo "<script>alert('Supplier updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating supplier.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Supplier</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Supplier Number</label>
            <input type="text" name="supplier_number" class="form-control" value="<?php echo htmlspecialchars($supplier['supplier_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($supplier['address']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Telephone</label>
            <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($supplier['telephone']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Fax</label>
            <input type="text" name="fax" class="form-control" value="<?php echo htmlspecialchars($supplier['fax']); ?>">
        </div>
        <button type="submit" class="btn btn-success">Update Supplier</button>
        <a href="index.php" class="btn btn-secondary">Home</a>
    </form>
</div>
</body>
</html>
