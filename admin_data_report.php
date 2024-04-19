<?php
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to admin login page if not logged in
    header("Location: admin_login.php");
    exit();
}

// Database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['startDate'], $_POST['endDate'])) {
    $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($con, $_POST['endDate']);

    // Query to select users based on the date range
    $sql = "SELECT id, username, role, date_joined FROM users WHERE date_joined BETWEEN '$startDate' AND '$endDate' ORDER BY date_joined ASC";
    $result = mysqli_query($con, $sql);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Data Report</title>
    <style>
        /* Add your CSS here */
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>New User Data Report</h1>

    <!-- Date range form -->
    <form action="new_user_report.php" method="post">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" required>

        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" required>

        <button type="submit">Generate Report</button>
    </form>

    <?php if (!empty($result) && mysqli_num_rows($result) > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Date Joined</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td><?= htmlspecialchars($row['date_joined']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No new users found in the selected date range.</p>
    <?php endif; ?>

    <?php mysqli_close($con); ?>
</body>
</html>
