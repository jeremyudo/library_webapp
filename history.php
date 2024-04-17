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

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get the current user's UserID
$studentId = $_SESSION['StudentID'];

// Build the SQL query to retrieve both books and digital items
$query = "SELECT checkouts.ItemID, checkouts.ItemType, 
          CASE
              WHEN checkouts.ItemType = 'Book' THEN books.Title
              WHEN checkouts.ItemType = 'Digital Item' THEN digitalitems.Title
          END AS Title,
          checkouts.CheckoutDate, checkouts.ReturnDate, checkouts.CheckinDate
          FROM checkouts 
          INNER JOIN students ON students.StudentID = checkouts.UserID 
          LEFT JOIN books ON books.ISBN = checkouts.ItemID AND checkouts.ItemType = 'Book'
          LEFT JOIN digitalitems ON digitalitems.DigitalID = checkouts.ItemID AND checkouts.ItemType = 'Digital Item'
          WHERE checkouts.UserID = '$studentId'";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize filter criteria
    $filter_by = sanitize_input($_POST['filter_by']);
    $filter_value = sanitize_input($_POST['filter_value']);

    // Apply filters if they are provided
    if (!empty($filter_by) && !empty($filter_value)) {
        // Validate filter attribute to prevent SQL injection
        $allowed_filters = ['Title', 'ItemType', 'CheckoutDate', 'ReturnDate', 'CheckinDate'];
        if (in_array($filter_by, $allowed_filters)) {
            $query .= " AND $filter_by LIKE '%$filter_value%'";
        } else {
            echo "Invalid filter attribute.";
            exit;
        }
    }
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="/history.css">
    <link rel="stylesheet" href="styles/table.css"> <!-- Use your table.css file -->
</head>
<body>
    <div class="homeContent">
        <h2 class="title_history">Transaction History</h2>

        <!-- Filter form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="filter_by">Filter by:</label>
            <select name="filter_by" id="filter_by">
                <option value="Title">Title</option>
                <option value="ItemType">Item Type</option>
                <option value="CheckoutDate">Checkout Date</option>
                <option value="ReturnDate">Return Date</option>
                <option value="CheckinDate">Checkin Date</option>
            </select>
            <label for="filter_value">Filter Value:</label>
            <input type="text" name="filter_value" id="filter_value">
            <button type="submit">Apply Filter</button>
        </form>

        <?php
        if(mysqli_num_rows($result) > 0) {
            // Display transaction history in a table with the resultsTable class
            echo "<table class='resultsTable'>";
            echo "<tr><th>ItemID</th><th>ItemType</th><th>Title</th><th>Checkout Date</th><th>Return Date</th><th>Checkin Date</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['ItemID']}</td>";
                echo "<td>{$row['ItemType']}</td>";
                echo "<td>{$row['Title']}</td>";
                echo "<td>{$row['CheckoutDate']}</td>";
                echo "<td>{$row['ReturnDate']}</td>";
                echo "<td>{$row['CheckinDate']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No transaction history found.</p>";
        }

        mysqli_close($con);
        ?>
        <!-- Add a link back to the home page -->
        <p><a href="account.php">Back</a></p>
    </div>
</body>
</html>
