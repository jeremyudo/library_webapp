<?php
include 'navbar.php';
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

function sanitize_input($data) {
    if ($data === null) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$studentId = $_SESSION['StudentID'];

$query = "SELECT checkouts.ItemID, checkouts.ItemType, digitalmediaitem.MediaName, checkouts.CheckoutDate, checkouts.DueDate
          FROM checkouts 
          INNER JOIN students ON students.StudentID = checkouts.UserID 
          INNER JOIN digitalmediaitem ON digitalmediaitem.DigiID = checkouts.ItemID
          WHERE checkouts.UserID = '$studentId' AND checkouts.CheckinDate IS NULL";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filter_attribute = isset($_POST['filter_attribute']) ? sanitize_input($_POST['filter_attribute']) : '';
    $filter_value = isset($_POST['filter_value']) ? sanitize_input($_POST['filter_value']) : '';

    if (!empty($filter_attribute) && !empty($filter_value)) {
        $allowed_attributes = ['ItemID', 'ItemType', 'MediaName', 'CheckoutDate', 'DueDate'];
        if (in_array($filter_attribute, $allowed_attributes)) {
            $query .= " AND $filter_attribute LIKE '%$filter_value%'";
        } else {
            echo "Invalid filter attribute.";
            exit;
        }
    }
}

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
    <link rel="stylesheet" href="/view_book_checkouts.css">
</head>
<body>
<div class="homeContent">
    <h2 class="title_checkout">Items Currently Checked Out</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="filter_attribute">Filter by:</label>
        <select name="filter_attribute" id="filter_attribute">
            <option value="ItemID">ItemID</option>
            <option value="MediaName">MediaName</option>
            <option value="CheckoutDate">Checkout Date</option>
            <option value="DueDate">Due Date</option>
        </select>
        <label for="filter_value">Filter Value:</label>
        <input type="text" name="filter_value" id="filter_value">
        <button type="submit">Apply Filter</button>
    </form>

    <?php
    if(mysqli_num_rows($result) > 0) {
        echo "<table class='resultsTable'>";
        echo "<tr><th>ItemID</th><th>MediaName</th><th>Checkout Date</th><th>Due Date</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td><a href='details_digitalitem.php?DigiID={$row['ItemID']}'>{$row['ItemID']}</a></td>";
            echo "<td>{$row['MediaName']}</td>";
            echo "<td>{$row['CheckoutDate']}</td>";
            echo "<td>{$row['DueDate']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No digital items currently checked out.</p>";
    }

    mysqli_close($con);
    ?>
    <p><a href="account.php">Back</a></p>
</div>
</body>
</html>
