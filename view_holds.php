<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Perform database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Get the UserID of the logged-in student
$userID = $_SESSION['StudentID'];

// Query to retrieve holds placed by the logged-in student
$query = "SELECT * FROM holds WHERE UserID = '$userID'";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Holds</title>
    <link rel="stylesheet" href="styles/table.css"> <!-- Include your table.css file here -->
</head>
<body>
    <div class="homeContent">
        <h2>View Holds</h2>
        <table class="resultsTable">
            <tr>
                <th>HoldID</th>
                <th>ItemID</th>
                <th>ItemType</th>
                <th>UserID</th>
                <th>UserType</th>
                <th>HoldDate</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['HoldID'] . "</td>";
                    echo "<td>" . $row['ItemID'] . "</td>";
                    echo "<td>" . $row['ItemType'] . "</td>";
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "<td>" . $row['UserType'] . "</td>";
                    echo "<td>" . $row['HoldDate'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No holds found.</td></tr>";
            }
            ?>
        </table>
        <!-- Add a link back to the home page -->
        <p><a href="home.php">Back to Home</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
