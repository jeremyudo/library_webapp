<?php
include 'navbar.php';
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: prof_login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$studentID = $_SESSION['FacultyID'];
$query = "SELECT FineID, ItemID, ItemType, FineAmount, FineDate, Status FROM fines WHERE UserID = $studentID AND Status = 'Paid'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <link rel="stylesheet" href="view_holds.css"> 
</head>
<body>
    <div class="homeContent">
        <h2 class="title_transactions">View Transactions</h2>

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
                    echo "<td>" . $row['FineID'] . "</td>";
                    echo "<td>" . $row['ItemID'] . "</td>";
                    echo "<td>" . $row['ItemType'] . "</td>";
                    echo "<td>" . $row['FineAmount'] . "</td>";
                    echo "<td>" . $row['FineDate'] . "</td>";
                    echo "<td>" . $row['PaymentStatus'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No paid fines found.</td></tr>";
            }
            ?>
        </table>
        <p><a href="account2.php">Back</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
