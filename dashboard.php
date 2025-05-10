<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wellmeadows Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- optional -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        .dashboard-container {
            width: 800px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
        }
        h1 {
            margin-bottom: 30px;
        }
        .nav-buttons a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            transition: 0.3s;
        }
        .nav-buttons a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>🏥 Wellmeadows Hospital Dashboard</h1>

    <div class="nav-buttons">
        <a href="index.php">Manage Staff</a>
        <a href="patients/index.php">Manage Patients</a>
        <a href="wards/index.php">Manage Wards</a>
    </div>
</div>

</body>
</html>
