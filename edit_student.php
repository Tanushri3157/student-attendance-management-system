<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";

if (!isset($_GET['id'])) {
    die("Student ID not found.");
}

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Student not found.");
}

$message = "";

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $course = $_POST['course'];
    $email = $_POST['email'];

    $sql = "UPDATE students SET
            name='$name',
            roll_no='$roll_no',
            course='$course',
            email='$email'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: students.php");
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h1>Edit Student</h1>

<p><?php echo $message; ?></p>

<form method="POST">

    <label>Student Name:</label><br>
    <input type="text" name="name"
           value="<?php echo htmlspecialchars($student['name']); ?>"
           required>

    <br><br>

    <label>Roll Number:</label><br>
    <input type="text" name="roll_no"
           value="<?php echo htmlspecialchars($student['roll_no']); ?>"
           required>

    <br><br>

    <label>Course:</label><br>
    <input type="text" name="course"
           value="<?php echo htmlspecialchars($student['course']); ?>">

    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email"
           value="<?php echo htmlspecialchars($student['email']); ?>">

    <br><br>

    <button type="submit" name="update">
        Update Student
    </button>

</form>

<br>

<a href="students.php">Back to Students</a>

</body>
</html>