<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['digitalid'])) {
    header("Location: admin_view_digitalitems.php");
    exit();
}

$digitalID = $_GET['digitalid'];

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$sql_digital = "SELECT * FROM digitalitems WHERE DigitalID = '$digitalID'";
$result_digital = mysqli_query($con, $sql_digital);
$digital_item = mysqli_fetch_assoc($result_digital);

$sql_checkout_history = "SELECT c.CheckoutDate, c.ReturnDate, c.CheckinDate, c.UserID, s.FirstName, s.LastName
                         FROM checkouts c
                         INNER JOIN students s ON c.UserID = s.StudentID
                         WHERE c.ItemID = '$digitalID' AND c.ItemType = 'Digital Item'";
$result_checkout_history = mysqli_query($con, $sql_checkout_history);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Item Checkout History</title>
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
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">Digital Item Details</h2> 

    <?php
        echo "<p style='margin-left: 10rem;'>Digital ID: " . $digital_item['DigitalID'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Stock: " . $digital_item['Stock'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Title: " . $digital_item['Title'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Author/Artist: " . $digital_item['Author'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Format: " . $digital_item['Format'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Publisher/Studio: " . $digital_item['Publisher'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Publication Year: " . $digital_item['PublicationYear'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Genre: " . $digital_item['Genre'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Language: " . $digital_item['Language'] . "</p>";

        if (mysqli_num_rows($result_checkout_history) > 0) {
            echo "<h3 style='margin-left: 10rem;'>Checkout History</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Checkout Date</th>
                        <th>Return Date</th>
                        <th>Checkin Date</th>
                        <th>User ID</th>
                        <th>Student Name</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result_checkout_history)) {
                echo "<tr>";
                echo "<td>" . $row['CheckoutDate'] . "</td>";
                echo "<td>" . $row['ReturnDate'] . "</td>";
                echo "<td>" . $row['CheckinDate'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No checkout history found for this digital item.</p>";
        }

        mysqli_close($con);
    ?>
</body>
</html>
