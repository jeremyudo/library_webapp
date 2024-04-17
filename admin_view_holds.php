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

// Query to retrieve all holds
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
        /* styles/table.css */

    /* styles/table.css */
body {
    font-family: 'Courier New', Courier, monospace; /* Applying Courier New font throughout the page */
    background-color: #f4f4f4; /* Light grey background for better contrast */
    margin: 0;
    padding: 0;
}

h2 {
    margin-left: 10rem; /* Matching the margin for consistency */
    margin-top: 5rem;
}

.resultsTable {
    width: 98%; /* Full width of the container */
    border-collapse: collapse; /* Eliminates double borders */
    margin-left: 1rem;
    margin-right: 1rem;
}

.resultsTable th, .resultsTable td {
    border: 1px solid black; /* Black borders for cells */
    padding: 8px; /* Padding inside cells */
    text-align: left; /* Text aligned to the left */
}

.resultsTable th {
    background-color: #f2f2f2; /* Light gray background for headers */
}

a {
    color: #3366cc; /* Styling links with a default blue */
    text-decoration: none; /* Removing underline from links */
    padding: 5px 10px; /* Padding for clickable area */
    display: inline-block; /* Making the anchor behave like a block element */
}

a:hover {
    text-decoration: underline; /* Adding underline on hover */
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
        <!-- Add a link back to the home page -->
        <p><a href="admin_home.php">Back</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
