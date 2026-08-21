<?php

session_start();

include "config.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

$user_name = $_SESSION["user_name"];
$user_role = $_SESSION["user_role"];

$total_students = 0;

$result = $conn->query("SELECT COUNT(*) AS total FROM students");

if ($result) {

    $row = $result->fetch_assoc();

    $total_students = $row["total"];

}

$recent_students = $conn->query(
    "SELECT name, email, course, created_at
     FROM students
     ORDER BY created_at DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - Student Management System</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Student Management System</h1>

    <p>
        Welcome, <?php echo htmlspecialchars($user_name); ?>!
    </p>

    <p>
        Role:
        <?php echo htmlspecialchars($user_role); ?>
    </p>

    <hr>

    <h2>Dashboard</h2>

    <div>

        <h3>Total Students</h3>

        <p>
            <?php echo $total_students; ?>
        </p>

    </div>

    <h2>Recent Registrations</h2>

    <?php if ($recent_students && $recent_students->num_rows > 0): ?>

        <table border="1" cellpadding="8">

            <tr>

                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Registered</th>

            </tr>

            <?php while ($student = $recent_students->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($student["name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($student["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($student["course"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($student["created_at"]); ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <p>No students have been added yet.</p>

    <?php endif; ?>

    <br>

    <a href="add_student.php">Add Student</a>

    <br><br>

    <a href="logout.php">Logout</a>

</body>

</html>