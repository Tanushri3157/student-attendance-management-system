<?php

include "db.php";

if (!isset($_GET['id'])) {
    die("Student ID not found.");
}

$id = $_GET['id'];

// First delete attendance records
$sql1 = "DELETE FROM attendance WHERE student_id=$id";

if (mysqli_query($conn, $sql1)) {

    // Then delete student
    $sql2 = "DELETE FROM students WHERE id=$id";

    if (mysqli_query($conn, $sql2)) {

        header("Location: students.php");
        exit();

    } else {

        echo "Error deleting student: " . mysqli_error($conn);
    }

} else {

    echo "Error deleting attendance: " . mysqli_error($conn);
}

?>