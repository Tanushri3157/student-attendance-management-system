<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Total students
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$data = mysqli_fetch_assoc($result);
$total_students = $data['total'];

// Total present
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE status='Present'");
$data = mysqli_fetch_assoc($result);
$total_present = $data['total'];

// Total absent
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE status='Absent'");
$data = mysqli_fetch_assoc($result);
$total_absent = $data['total'];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance Dashboard</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="dashboard">

    <h1>Attendance Management System</h1>

    <h2>Admin Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>Total Students</h3>
            <p><?php echo $total_students; ?></p>
        </div>

        <div class="card">
            <h3>Total Present</h3>
            <p><?php echo $total_present; ?></p>
        </div>

        <div class="card">
            <h3>Total Absent</h3>
            <p><?php echo $total_absent; ?></p>
        </div>

    </div>

    <hr>

    <h3>Student Management</h3>

    <a href="add_student.php">Add Student</a>

    <a href="students.php">View Students</a>

    <hr>

    <h3>Attendance Management</h3>

    <a href="attendance.php">Mark Attendance</a>

    <a href="report.php">Attendance Report</a>

    <hr>

    <a href="logout.php">Logout</a>

</div>

</body>

</html>