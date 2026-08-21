<?php

include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {

        $message = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "This email is already registered.";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );

            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {

    header("Location: login.php?registered=1");
    exit();

} else {

    $message = "Something went wrong. Please try again.";
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

    <title>Register - Student Management System</title>
    <link rel="stylesheet" href="style.css">

</head>

<body class="auth-page">

    <div class="auth-card">

    <h1>Student Management System</h1>

    <h2>Create Account</h2>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label>Name</label>

            <input
                type="text"
                name="name"
                required
            >

        </div>

        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                required
            >

        </div>

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                required
            >

        </div>

        <button type="submit" class="primary-button">
            Register
        </button>

    </form>

    <div class="auth-link">

        <p>
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</div>

</body>

</html>