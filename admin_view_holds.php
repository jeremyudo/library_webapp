<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$query = "SELECT * FROM holds";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Holds - Admin</title>
    <style>

body {
    font-family: 'Courier New', Courier, monospace; 
    background-color: #f4f4f4; 
    margin: 0;
    padding: 0;
}

h2 {
    margin-left: 10rem; 
    margin-top: 5rem;
}

.resultsTable {
    width: 98%; 
    border-collapse: collapse; 
    margin-left: 1rem;
    margin-right: 1rem;
}

.resultsTable th, .resultsTable td {
    border: 1px solid black; 
    padding: 8px; 
    text-align: left; 
}

.resultsTable th {
    background-color: #f2f2f2; 
}

a {
    color: #3366cc; 
    text-decoration: none; 
    padding: 5px 10px;
    display: inline-block; 
}

a:hover {
    text-decoration: underline; 
}

    </style>
</head>
<body>
    <div class="homeContent">
        <h2>View Holds - Admin</h2>
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
        <p><a href="admin_home.php">Back</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
