<?php
include 'navbar.php';
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

// Query fines for the logged-in student with status 'Unpaid'
$studentID = $_SESSION['StudentID'];
$query = "SELECT FineID, ItemID, ItemType, FineAmount, FineDate, Status FROM fines WHERE UserID = $studentID AND Status = 'Unpaid'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Fines</title>
    <link rel="stylesheet" href="view_holds.css"> <!-- Include your table.css file here -->
</head>
<body>
    <div class="homeContent">
        <h2 class="title_fines">View Unpaid Fines</h2>

        <table class="resultsTable">
            <tr>
                <th>Fine ID</th>
                <th>Item ID</th>
                <th>Item Type</th>
                <th>Fine Amount</th>
                <th>Fine Date</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><a href='pay_fine.php?fine_id=" . $row['FineID'] . "'>" . $row['FineID'] . "</a></td>";
                    echo "<td>" . $row['ItemID'] . "</td>";
                    echo "<td>" . $row['ItemType'] . "</td>";
                    echo "<td>" . $row['FineAmount'] . "</td>";
                    echo "<td>" . $row['FineDate'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No unpaid fines found.</td></tr>";
            }
            ?>
        </table>
        <!-- Add a link back to the home page -->
        <p><a href="account.php">Back</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
