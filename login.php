<?php

session_start();

include "config.php";

$message = "";

if (isset($_GET["registered"])) {
    $message = "Registration successful! You can now login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password, role FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_role"] = $user["role"];

                header("Location: dashboard.php");
                exit();

            } else {

                $message = "Incorrect password.";

            }

        } else {

            $message = "No account found with this email.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Student Management System</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="auth-page">

    <div class="auth-card">


    <h1>Student Management System</h1>

    <h2>Login</h2>

    <?php if (!empty($message)): ?>

        <p><?php echo htmlspecialchars($message); ?></p>

    <?php endif; ?>

    <form method="POST">

        <label>Email</label>
        <br>

        <input
            type="email"
            name="email"
            required
        >

        <br><br>

        <label>Password</label>
        <br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</body>

</html>