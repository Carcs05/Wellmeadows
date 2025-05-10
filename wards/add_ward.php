<?php
// Include database connection
include '../db_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ward_name = $_POST['ward_name'];
    $location = $_POST['location'];
    $total_beds = $_POST['total_beds'];
    $telephone_extension = $_POST['telephone_extension'];

    try {
        $stmt = $conn->prepare("INSERT INTO ward (ward_name, location, total_beds, telephone_extension) 
                                VALUES (:ward_name, :location, :total_beds, :telephone_extension)");
        $stmt->execute([
            ':ward_name' => $ward_name,
            ':location' => $location,
            ':total_beds' => $total_beds,
            ':telephone_extension' => $telephone_extension
        ]);

        // Redirect to ward list after successful insert
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding ward: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Ward</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Ward</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="ward_name" class="form-label">Ward Name</label>
            <input type="text" name="ward_name" id="ward_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_beds" class="form-label">Total Beds</label>
            <input type="number" name="total_beds" id="total_beds" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telephone_extension" class="form-label">Telephone Extension</label>
            <input type="text" name="telephone_extension" id="telephone_extension" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Ward</button>
    </form>

</div>
</body>
</html>
