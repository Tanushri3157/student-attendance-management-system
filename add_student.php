<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$message = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $course = $_POST['course'];
    $email = $_POST['email'];

    $sql = "INSERT INTO students (name, roll_no, course, email)
            VALUES ('$name', '$roll_no', '$course', '$email')";

    if (mysqli_query($conn, $sql)) {
        $message = "Student added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Student</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Add Student</h1>

<a href="dashboard.php">Dashboard</a>

<a href="students.php">View Students</a>

<br><br>

<p>
    <?php echo htmlspecialchars($message); ?>
</p>

<form method="POST">

    <label>Student Name:</label>
    <br>

    <input
        type="text"
        name="name"
        required
    >

    <br><br>

    <label>Roll Number:</label>
    <br>

    <input
        type="text"
        name="roll_no"
        required
    >

    <br><br>

    <label>Course:</label>
    <br>

    <input
        type="text"
        name="course"
    >

    <br><br>

    <label>Email:</label>
    <br>

    <input
        type="email"
        name="email"
    >

    <br><br>

    <button type="submit" name="submit">
        Add Student
    </button>

</form>

<br>

<a href="logout.php">Logout</a>

</body>

</html>