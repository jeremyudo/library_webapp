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
$query = "SELECT books.Title, books.Author, books.ISBN, books.Format, holds.HoldDate, holds.Status FROM holds INNER JOIN books ON holds.ISBN = books.ISBN";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Holds - Admin</title>
    <link rel="stylesheet" href="styles/table.css"> <!-- Include your table.css file here -->
</head>
<body>
    <div class="homeContent">
        <h2>View Holds - Admin</h2>
        <table class="resultsTable">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Format</th>
                <th>Hold Date</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // Make the Title column a link to the book details page
                    echo "<td><a href='details_item.php?isbn=" . $row['ISBN'] . "'>" . $row['Title'] . "</a></td>";
                    echo "<td>" . $row['Author'] . "</td>";
                    echo "<td>" . $row['ISBN'] . "</td>";
                    echo "<td>" . $row['Format'] . "</td>";
                    echo "<td>" . $row['HoldDate'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No holds found.</td></tr>";
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
