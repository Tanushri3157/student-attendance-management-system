<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if ($search != "") {

    $sql = "SELECT * FROM students
            WHERE name LIKE '%$search%'
            OR roll_no LIKE '%$search%'
            OR course LIKE '%$search%'
            ORDER BY id DESC";

} else {

    $sql = "SELECT * FROM students ORDER BY id DESC";

}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Students List</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Students List</h1>

<a href="dashboard.php">Dashboard</a>
<a href="add_student.php">Add New Student</a>

<br><br>

<h3>Search Student</h3>

<form method="GET">

    <input
        type="text"
        name="search"
        placeholder="Name, Roll No or Course"
        value="<?php echo htmlspecialchars($search); ?>"
    >

    <button type="submit">Search</button>

    <a href="students.php">Show All</a>

</form>

<br>

<table>

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll No</th>
        <th>Course</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <tr>

        <td><?php echo $row['id']; ?></td>

        <td><?php echo htmlspecialchars($row['name']); ?></td>

        <td><?php echo htmlspecialchars($row['roll_no']); ?></td>

        <td><?php echo htmlspecialchars($row['course']); ?></td>

        <td><?php echo htmlspecialchars($row['email']); ?></td>

        <td>

            <a href="edit_student.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>

            <a href="delete_student.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure you want to delete this student?');">
                Delete
            </a>

        </td>

    </tr>

    <?php

        }

    } else {

    ?>

    <tr>

        <td colspan="6">
            No student found.
        </td>

    </tr>

    <?php

    }

    ?>

</table>

<br>

<a href="logout.php">Logout</a>

</body>

</html>