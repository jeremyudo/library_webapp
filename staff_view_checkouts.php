<?php
session_start();

if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header("Location: staff_login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$query = "SELECT ItemID, ItemType, UserID, UserType, CheckoutDate, DueDate, CheckInDate FROM checkouts";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Checkouts - Staff</title>
    <style>
.resultsTable {
    border-collapse: collapse;
    width: 100%;
}

.resultsTable th, .resultsTable td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.resultsTable th {
    background-color: #f2f2f2;
}

body {
    font-family: 'Courier New', Courier, monospace;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
}

.homeContent {
    width: 90%;
    margin: auto;
    padding: 20px;
    border-radius: 8px;
}

h2 {
    margin-bottom: 20px;
}

a {
    color: #4A90E2;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="homeContent">
        <h2>View Checkouts - Staff</h2>
        <table class="resultsTable">
            <tr>
                <th>ItemID</th>
                <th>ItemType</th>
                <th>UserID</th>
                <th>UserType</th>
                <th>Checkout Date</th>
                <th>Due Date</th>
                <th>Check-in Date</th>
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
                    echo "<td>" . $row['DueDate'] . "</td>";
                    echo "<td>" . $row['CheckInDate'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No checkouts found.</td></tr>";
            }
            ?>
        </table>
        <p><a href="staff_home.php">Back</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>