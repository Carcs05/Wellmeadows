<?php
// Include database connection
include '../db_connection.php';

// Get ward_id from URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$ward_id = $_GET['id'];

// Fetch ward data
try {
    $stmt = $conn->prepare("SELECT * FROM ward WHERE ward_id = :ward_id");
    $stmt->execute([':ward_id' => $ward_id]);
    $ward = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ward) {
        echo "Ward not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching ward: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ward_name = $_POST['ward_name'];
    $location = $_POST['location'];
    $total_beds = $_POST['total_beds'];
    $telephone_extension = $_POST['telephone_extension'];

    try {
        $stmt = $conn->prepare("UPDATE ward SET ward_name = :ward_name, location = :location, total_beds = :total_beds, telephone_extension = :telephone_extension WHERE ward_id = :ward_id");
        $stmt->execute([
            ':ward_name' => $ward_name,
            ':location' => $location,
            ':total_beds' => $total_beds,
            ':telephone_extension' => $telephone_extension,
            ':ward_id' => $ward_id
        ]);

        // Redirect back to ward list
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating ward: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Ward</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Ward</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </div>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="ward_name" class="form-label">Ward Name</label>
            <input type="text" name="ward_name" id="ward_name" class="form-control" value="<?php echo htmlspecialchars($ward['ward_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($ward['location']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="total_beds" class="form-label">Total Beds</label>
            <input type="number" name="total_beds" id="total_beds" class="form-control" value="<?php echo htmlspecialchars($ward['total_beds']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="telephone_extension" class="form-label">Telephone Extension</label>
            <input type="text" name="telephone_extension" id="telephone_extension" class="form-control" value="<?php echo htmlspecialchars($ward['telephone_extension']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Ward</button>
    </form>

</div>
</body>
</html>
