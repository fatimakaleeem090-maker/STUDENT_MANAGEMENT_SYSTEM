<?php

session_start();

include "config.php";

/* Check login */
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";
$message_type = "";

/* Handle form submission */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $semester = trim($_POST["semester"] ?? "");
    $address = trim($_POST["address"] ?? "");

    /* Basic validation */

    if (empty($name) || empty($email) || empty($course)) {

        $message = "Please fill in all required fields.";
        $message_type = "error-message";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $message_type = "error-message";

    } elseif (!empty($semester) && ($semester < 1 || $semester > 12)) {

        $message = "Semester must be between 1 and 12.";
        $message_type = "error-message";

    } else {

        /* Check if email already exists */

        $check = $conn->prepare(
            "SELECT id FROM students WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {

            $message = "A student with this email already exists.";
            $message_type = "error-message";

        } else {

            /* Insert student */

            $stmt = $conn->prepare(
                "INSERT INTO students
                (name, email, phone, course, semester, address)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssssss",
                $name,
                $email,
                $phone,
                $course,
                $semester,
                $address
            );

            if ($stmt->execute()) {

                $message = "Student added successfully.";
                $message_type = "success-message";

                /* Clear form values after successful insertion */

                $name = "";
                $email = "";
                $phone = "";
                $course = "";
                $semester = "";
                $address = "";

            } else {

                $message = "Unable to add student. Please try again.";
                $message_type = "error-message";
            }

            $stmt->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student - Student Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- Top Navigation -->

    <header class="top-bar">

        <div class="logo">
            Student Management System
        </div>

        <div class="user-area">

            <span>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
            </span>

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </header>


    <!-- Main Content -->

    <main class="page-container">

        <div class="page-header">

            <div>

                <h1>Add Student</h1>

                <p>
                    Add a new student to the system.
                </p>

            </div>

            <a
                href="students.php"
                class="secondary-button"
            >
                View Students
            </a>

        </div>


        <!-- Message -->

        <?php if (!empty($message)): ?>

            <div class="<?php echo $message_type; ?>">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>


        <!-- Student Form -->

        <div class="form-card">

            <form method="POST" id="studentForm">

                <!-- Name -->

                <div class="form-group">

                    <label for="name">

                        Student Name
                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo htmlspecialchars($name); ?>"
                        placeholder="Enter student's full name"
                        required
                    >

                </div>


                <!-- Email -->

                <div class="form-group">

                    <label for="email">

                        Email
                        <span class="required">*</span>

                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        placeholder="Enter student's email"
                        required
                    >

                    <p class="help-text">
                        Enter a valid email address.
                    </p>

                </div>


                <!-- Phone -->

                <div class="form-group">

                    <label for="phone">
                        Phone
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="<?php echo htmlspecialchars($phone); ?>"
                        placeholder="Enter phone number"
                    >

                </div>


                <!-- Course -->

                <div class="form-group">

                    <label for="course">

                        Course
                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        id="course"
                        name="course"
                        value="<?php echo htmlspecialchars($course); ?>"
                        placeholder="e.g. BS Computer Science"
                        required
                    >

                </div>


                <!-- Semester -->

                <div class="form-group">

                    <label for="semester">
                        Semester
                    </label>

                    <input
                        type="number"
                        id="semester"
                        name="semester"
                        min="1"
                        max="12"
                        value="<?php echo htmlspecialchars($semester); ?>"
                        placeholder="Enter semester"
                    >

                    <p class="help-text">
                        Enter a semester between 1 and 12.
                    </p>

                </div>


                <!-- Address -->

                <div class="form-group">

                    <label for="address">
                        Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        placeholder="Enter student's address"
                    ><?php echo htmlspecialchars($address); ?></textarea>

                </div>


                <!-- Buttons -->

                <div class="form-actions">

                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Add Student
                    </button>

                    <a
                        href="students.php"
                        class="secondary-button"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </main>


    <!-- Loading Indicator -->

    <div class="loading-overlay">

        <div class="loading-box">

            <div class="spinner"></div>

            <p>
                Adding student, please wait...
            </p>

        </div>

    </div>


    <!-- Loading JavaScript -->

    <script src="js/loading.js"></script>

</body>

</html>