<?php

session_start();

include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$search = "";
$limit = 5;

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if (!empty($search)) {

    $stmt = $conn->prepare(
        "SELECT * FROM students
         WHERE name LIKE ?
         OR email LIKE ?
         OR course LIKE ?
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset"
    );

    $search_value = "%" . $search . "%";

    $stmt->bind_param(
        "sss",
        $search_value,
        $search_value,
        $search_value
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

   $result = $conn->query(
    "SELECT * FROM students
     ORDER BY id DESC
     LIMIT $limit OFFSET $offset"
);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students - Student Management System</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

<main class="page-container">

    <div class="page-header">

        <div>

            <h1>Students</h1>

            <p>View and manage student records.</p>

        </div>

        <a href="add_student.php" class="primary-button">
            + Add Student
        </a>

    </div>

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search by name, email or course..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">
                Search
            </button>

            <a href="students.php" class="secondary-button">
                Clear
            </a>

        </form>

    </div>

    <?php if ($result && $result->num_rows > 0): ?>

        <div class="table-card">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($student = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($student["id"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($student["name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($student["email"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($student["phone"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($student["course"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($student["semester"]); ?>
                            </td>

                            <td class="action-links">

                                <a href="student_details.php?id=<?php echo $student["id"]; ?>">
                                    View
                                </a>

                                <a href="edit_student.php?id=<?php echo $student["id"]; ?>">
                                    Edit
                                </a>

                                <a
                                    href="delete_student.php?id=<?php echo $student["id"]; ?>"
                                    class="delete-link"
                                    onclick="return confirm('Are you sure you want to delete this student?');"
                                >
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="empty-state">

            <p>No students found.</p>

            <br>

            <a href="add_student.php" class="primary-button">
                Add Student
            </a>

        </div>

    <?php endif; ?>

<?php

$count_result = $conn->query(
    "SELECT COUNT(*) AS total FROM students"
);

$count_row = $count_result->fetch_assoc();

$total_students = $count_row["total"];

$total_pages = ceil($total_students / $limit);

?>

<?php if ($total_pages > 1): ?>

    <div class="pagination">

        <?php if ($page > 1): ?>

            <a href="students.php?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                Previous
            </a>

        <?php endif; ?>


        <?php for ($i = 1; $i <= $total_pages; $i++): ?>

            <a
                href="students.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                class="<?php echo ($i == $page) ? 'active' : ''; ?>"
            >
                <?php echo $i; ?>
            </a>

        <?php endfor; ?>


        <?php if ($page < $total_pages): ?>

            <a href="students.php?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
                Next
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>
</main>

</body>

</body>

</html>
