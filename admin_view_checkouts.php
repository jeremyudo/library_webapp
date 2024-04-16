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

// Query to retrieve all checkouts
$query = "SELECT ItemID, ItemType, UserID, UserType, CheckoutDate, ReturnDate, CheckInDate FROM checkouts";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Checkouts - Admin</title>
    <link rel="stylesheet" href="styles/table.css"> <!-- Include your table.css file here -->
</head>
<body>
    <div class="homeContent">
        <h2>View Checkouts - Admin</h2>
        <table class="resultsTable">
            <tr>
                <th>ItemID</th>
                <th>ItemType</th>
                <th>UserID</th>
                <th>UserType</th>
                <th>CheckoutDate</th>
                <th>ReturnDate</th>
                <th>CheckInDate</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ItemID'] . "</td>";
                    echo "<td>" . $row['ItemType'] . "</td>";
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "<td>" . $row['UserType'] . "</td>";
                    echo "<td>" . $row['CheckoutDate'] . "</td>";
                    echo "<td>" . $row['ReturnDate'] . "</td>";
                    echo "<td>" . $row['CheckInDate'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No checkouts found.</td></tr>";
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
