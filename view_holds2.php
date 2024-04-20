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

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filter_by = sanitize_input($_POST['filter_by']);
    $filter_value = sanitize_input($_POST['filter_value']);

    $query = "SELECT holds.ItemID, holds.ItemType, books.Title, holds.HoldDate, holds.Status FROM holds INNER JOIN books ON holds.ItemID = books.ISBN";

    if (!empty($filter_by) && !empty($filter_value)) {
        $allowed_filters_books = ['Title', 'Author', 'ISBN', 'Format'];
        $allowed_filters_holds = ['ItemID', 'ItemType', 'HoldDate', 'Status'];
    
        if (in_array($filter_by, $allowed_filters_books)) {
            $query .= " WHERE books.$filter_by LIKE '%$filter_value%'";
        } elseif (in_array($filter_by, $allowed_filters_holds)) {
            $query .= " WHERE holds.$filter_by LIKE '%$filter_value%'";
        } else {
            echo "Invalid filter attribute.";
            exit;
        }
    }

    $result = mysqli_query($con, $query);
} else {
    $query = "SELECT holds.ItemID, holds.ItemType, books.Title, holds.HoldDate, holds.Status FROM holds INNER JOIN books ON holds.ItemID = books.ISBN";
    $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Holds</title>
    <link rel="stylesheet" href="view_holds.css">
</head>
<body>
    <div class="homeContent">
        <h2 class="title_holds">View Holds</h2>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="filter_by">Filter by:</label>
            <select name="filter_by" id="filter_by">
                <option value="ItemID">ItemID</option>
                <option value="ItemType">ItemType</option>
                <option value="Title">Title</option>
                <option value="HoldDate">HoldDate</option>
                <option value="Status">Status</option>
            </select>
            <label for="filter_value">Filter Value:</label>
            <input type="text" name="filter_value" id="filter_value">
            <button type="submit">Apply Filter</button>
        </form>

        <table class="resultsTable">
            <tr>
                <th>Item ID</th>
                <th>Item Type</th>
                <th>Title</th>
                <th>Hold Date</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><a href='details_book.php?isbn=" . $row['ItemID'] . "'>" . $row['Title'] . "</a></td>";
                    echo "<td>" . $row['ItemType'] . "</td>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['HoldDate'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No holds found.</td></tr>";
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
