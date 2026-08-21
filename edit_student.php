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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);
    $semester = trim($_POST["semester"]);
    $address = trim($_POST["address"]);

    if (empty($name) || empty($email) || empty($course)) {

        $message = "Please fill in the required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } else {

        $update = $conn->prepare(
            "UPDATE students
             SET name = ?, email = ?, phone = ?, course = ?,
                 semester = ?, address = ?
             WHERE id = ?"
        );

        $update->bind_param(
            "ssssssi",
            $name,
            $email,
            $phone,
            $course,
            $semester,
            $address,
            $id
        );

        if ($update->execute()) {

            header("Location: students.php");
            exit();

        } else {

            $message = "Unable to update student.";

        }

        $update->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

   <body>

<main class="page-container">

    <div class="page-header">

        <div>

            <h1>Edit Student</h1>

            <p>Update the student's information.</p>

        </div>

        <a href="students.php" class="secondary-button">
            Back to Students
        </a>

    </div>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <div class="form-card">

        <form method="POST">

            <div class="form-group">

                <label>Student Name *</label>

                <input
                    type="text"
                    name="name"
                    value="<?php echo htmlspecialchars($student["name"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Email *</label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($student["email"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="<?php echo htmlspecialchars($student["phone"]); ?>"
                >

            </div>

            <div class="form-group">

                <label>Course *</label>

                <input
                    type="text"
                    name="course"
                    value="<?php echo htmlspecialchars($student["course"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Semester</label>

                <input
                    type="number"
                    name="semester"
                    min="1"
                    max="12"
                    value="<?php echo htmlspecialchars($student["semester"]); ?>"
                >

            </div>

            <div class="form-group">

                <label>Address</label>

                <textarea name="address"><?php echo htmlspecialchars($student["address"]); ?></textarea>

            </div>

            <div class="form-actions">

                <button type="submit" class="primary-button">
                    Update Student
                </button>

                <a href="students.php" class="secondary-button">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</main>

</body>

</body>

</html>