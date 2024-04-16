<?php
include 'navbar.php';
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Function to sanitize user input
function sanitize_input($data) {
    if ($data === null) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Establish database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

// Get the current user's StudentID
$studentId = $_SESSION['StudentID'];

// Default query to retrieve checkout records for the current user where CheckinDate is NULL
$query = "SELECT checkouts.ItemID, checkouts.ItemType, books.Title, checkouts.CheckoutDate, checkouts.ReturnDate
          FROM checkouts 
          INNER JOIN students ON students.StudentID = checkouts.UserID 
          INNER JOIN books ON books.ISBN = checkouts.ItemID 
          WHERE checkouts.UserID = '$studentId' AND checkouts.CheckinDate IS NULL";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize filter criteria
    $filter_attribute = isset($_POST['filter_attribute']) ? sanitize_input($_POST['filter_attribute']) : '';
    $filter_value = isset($_POST['filter_value']) ? sanitize_input($_POST['filter_value']) : '';

    // Apply filters if they are provided
    if (!empty($filter_attribute) && !empty($filter_value)) {
        // Validate filter attribute to prevent SQL injection
        $allowed_attributes = ['ItemID', 'ItemType', 'Title', 'CheckoutDate', 'ReturnDate'];
        if (in_array($filter_attribute, $allowed_attributes)) {
            $query .= " AND $filter_attribute LIKE '%$filter_value%'";
        } else {
            echo "Invalid filter attribute.";
            exit;
        }
    }
}

// Perform the database query
$result = mysqli_query($con, $query);
if (!$result) {
    die('Error executing query: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Checkouts</title>
    <link rel="stylesheet" href="/view_checkouts.css">
    <link rel="stylesheet" href="styles/table.css"> <!-- Add the table.css file -->
</head>
<body>
<div class="homeContent">
    <h2 class="title_checkout">Digital Items Currently Checked Out</h2>

    <!-- Filter form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="filter_attribute">Filter by:</label>
        <select name="filter_attribute" id="filter_attribute">
            <option value="ItemID">ItemID</option>
            <option value="ItemType">Item Type</option>
            <option value="Title">Title</option>
            <option value="CheckoutDate">Checkout Date</option>
            <option value="ReturnDate">Due Date</option>
        </select>
        <label for="filter_value">Filter Value:</label>
        <input type="text" name="filter_value" id="filter_value">
        <!-- Add more input fields for additional filters if needed -->
        <button type="submit">Apply Filter</button>
    </form>

    <?php
    if(mysqli_num_rows($result) > 0) {
        // Display checkout records in a table with the resultsTable class
        echo "<table class='resultsTable'>";
        echo "<tr><th>ItemID</th><th>Item Type</th><th>Title</th><th>Checkout Date</th><th>Due Date</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['ItemID']}</td>";
            echo "<td>{$row['ItemType']}</td>";
            echo "<td>{$row['Title']}</td>";
            echo "<td>{$row['CheckoutDate']}</td>";
            echo "<td>{$row['ReturnDate']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No digital items currently checked out.</p>";
    }

    mysqli_close($con);
    ?>
    <!-- Add a link back to the home page -->
    <p><a href="account.php">Back</a></p>
</div>
</body>
</html>
