<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$selected_date = "";

if (isset($_GET['attendance_date'])) {
    $selected_date = $_GET['attendance_date'];
}

if ($selected_date != "") {

    $sql = "SELECT
                students.name,
                students.roll_no,
                attendance.attendance_date,
                attendance.status
            FROM attendance
            INNER JOIN students
            ON attendance.student_id = students.id
            WHERE attendance.attendance_date = '$selected_date'
            ORDER BY students.roll_no";

} else {

    $sql = "SELECT
                students.name,
                students.roll_no,
                attendance.attendance_date,
                attendance.status
            FROM attendance
            INNER JOIN students
            ON attendance.student_id = students.id
            ORDER BY attendance.attendance_date DESC";

}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance Report</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Attendance Report</h1>

<a href="dashboard.php">Dashboard</a>

<a href="attendance.php">Mark Attendance</a>

<br><br>

<h3>Filter Attendance by Date</h3>

<form method="GET">

    <label>Select Date:</label>

    <input
        type="date"
        name="attendance_date"
        value="<?php echo htmlspecialchars($selected_date); ?>"
    >

    <button type="submit">
        Show Attendance
    </button>

    <a href="report.php">
        Show All
    </a>

</form>

<br>

<table>

    <tr>

        <th>Roll No</th>
        <th>Student Name</th>
        <th>Date</th>
        <th>Status</th>

    </tr>

    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>

        <td>
            <?php echo htmlspecialchars($row['roll_no']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['name']); ?>
        </td>

        <td>
            <?php echo $row['attendance_date']; ?>
        </td>

        <td>
            <?php echo $row['status']; ?>
        </td>

    </tr>

    <?php

        }

    } else {

    ?>

    <tr>

        <td colspan="4">
            No attendance found for this date.
        </td>

    </tr>

    <?php

    }

    ?>

</table>

</body>

</html>