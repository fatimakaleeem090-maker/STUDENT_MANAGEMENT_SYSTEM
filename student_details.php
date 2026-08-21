<?php

session_start();

include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: students.php");
    exit();
}

$id = intval($_GET["id"]);

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: students.php");
    exit();
}

$student = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Details</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

   <body>

<main class="page-container">

    <div class="page-header">

        <div>

            <h1>Student Details</h1>

            <p>Complete information about this student.</p>

        </div>

        <a href="students.php" class="secondary-button">
            Back to Students
        </a>

    </div>

    <div class="details-card">

        <div class="detail-row">

            <div class="detail-label">
                Student ID
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["id"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Name
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["name"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Email
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["email"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Phone
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["phone"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Course
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["course"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Semester
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["semester"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Address
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["address"]); ?>
            </div>

        </div>

        <div class="detail-row">

            <div class="detail-label">
                Registered
            </div>

            <div class="detail-value">
                <?php echo htmlspecialchars($student["created_at"]); ?>
            </div>

        </div>

        <div class="details-actions">

            <a
                href="edit_student.php?id=<?php echo $student["id"]; ?>"
                class="primary-button"
            >
                Edit Student
            </a>

            <a
                href="students.php"
                class="secondary-button"
            >
                Back to Students
            </a>

        </div>

    </div>

</main>

</body>

</html>