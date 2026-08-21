<?php

session_start();

include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    $stmt = $conn->prepare(
        "DELETE FROM students WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

header("Location: students.php");

exit();

?>