<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$message = "";
$message_type = "";

if (isset($_POST['submit'])) {

    $student_id = $_POST['student_id'];
    $date = $_POST['attendance_date'];
    $status = $_POST['status'];

    // Check if attendance already exists
    $check_sql = "SELECT * FROM attendance
                  WHERE student_id='$student_id'
                  AND attendance_date='$date'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $message = "Attendance already marked for this student on this date.";
        $message_type = "error";

    } else {

        $sql = "INSERT INTO attendance
                (student_id, attendance_date, status)
                VALUES ('$student_id', '$date', '$status')";

        if (mysqli_query($conn, $sql)) {

            $message = "Attendance marked successfully!";
            $message_type = "success";

        } else {

            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
}

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY name");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Mark Attendance</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Mark Attendance</h1>

<a href="dashboard.php">Dashboard</a>

<a href="report.php">Attendance Report</a>

<br><br>

<?php if ($message != "") { ?>

    <p>
        <strong>
            <?php echo htmlspecialchars($message); ?>
        </strong>
    </p>

<?php } ?>

<form method="POST">

    <label>Student:</label>
    <br>

    <select name="student_id" required>

        <option value="">Select Student</option>

        <?php

        while ($row = mysqli_fetch_assoc($students)) {

        ?>

            <option value="<?php echo $row['id']; ?>">

                <?php echo htmlspecialchars($row['name']); ?>
                -
                <?php echo htmlspecialchars($row['roll_no']); ?>

            </option>

        <?php

        }

        ?>

    </select>

    <br><br>

    <label>Date:</label>
    <br>

    <input
        type="date"
        name="attendance_date"
        required
    >

    <br><br>

    <label>Status:</label>
    <br>

    <select name="status" required>

        <option value="Present">Present</option>
        <option value="Absent">Absent</option>

    </select>

    <br><br>

    <button type="submit" name="submit">
        Mark Attendance
    </button>

</form>

</body>

</html>