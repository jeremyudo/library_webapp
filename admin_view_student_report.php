<?php
    session_start();

    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: admin_login.php");
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Report</title>
    <style>
.resultsTable {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.resultsTable th,
.resultsTable td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}

.resultsTable th {
  background-color: #f2f2f2;
}

.resultsTable tr:nth-child(even) {
  background-color: #f2f2f2;
}

.resultsTable tr:hover {
  background-color: #ddd;
}

.title_holds {
  font-size: 30px;
}

.homeContent {
  font-family: 'Courier New', Courier, monospace;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

form {
  font-family: 'Courier New', Courier, monospace;
  margin-top: 20px;
}

form label {
  padding: 5px;
  margin-right: 10px;
  display: block; 
}

form input[type="text"] {
  font-family: 'Courier New', Courier, monospace;
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  margin-top: 5px; /* Add space between input fields */
  width: 20%; /* Make input fields fill the width */
}

form button[type="submit"] {
  font-family: 'Courier New', Courier, monospace;
  padding: 8px 16px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 130px;
  margin-top: 10px; 
}

form button[type="submit"]:hover {
  background-color: #45a049;
}

.homeContent p {
  margin-top: 20px; 
}

.homeContent a {
  color: #007bff;
  text-decoration: none;
}

.homeContent a:hover {
  text-decoration: underline;
}

.creditCardDetails {
  font-family: 'Courier New', Courier, monospace;
}

.creditCardDetails label {
  padding: 5px;
  margin-right: 10px;
  display: block; 
}

.creditCardDetails input[type="number"],
.creditCardDetails input[type="date"] {
  font-family: 'Courier New', Courier, monospace;
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  margin-top: 5px; 
  width: 20%; 
}

        
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Student Report</h2> 

    <?php
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $studentID = $_GET['student_id'];

        $sql_checkout = "SELECT c.ItemID, c.ItemType, 
                                CASE 
                                    WHEN c.ItemType = 'Book' THEN b.Title
                                    WHEN c.ItemType = 'Digital Item' THEN d.Title
                                    ELSE NULL
                                END AS Title,
                                CASE 
                                    WHEN c.ItemType = 'Book' THEN b.Author
                                    WHEN c.ItemType = 'Digital Item' THEN d.Author
                                    ELSE NULL
                                END AS Author,
                                c.CheckoutDate, c.ReturnDate, c.CheckinDate
                        FROM checkouts c 
                        LEFT JOIN books b ON c.ItemID = b.ISBN 
                        LEFT JOIN digitalitems d ON c.ItemID = d.DigitalID 
                        WHERE c.UserID = '$studentID'";
        $result_checkout = mysqli_query($con, $sql_checkout);

        $sql_hold = "SELECT * FROM holds WHERE UserID = '$studentID'";
        $result_hold = mysqli_query($con, $sql_hold);

        $sql_fines = "SELECT * FROM fines WHERE UserID = '$studentID'";
        $result_fines = mysqli_query($con, $sql_fines);

        $sql_lost_items = "SELECT * FROM lostitems WHERE UserID = '$studentID'";
        $result_lost_items = mysqli_query($con, $sql_lost_items);

        if (mysqli_num_rows($result_checkout) > 0) {
            echo "<h3>Checkout Records</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Checkout Date</th>
                        <th>Return Date</th>
                        <th>Check-in Date</th>
                    </tr>";

            while ($row_checkout = mysqli_fetch_assoc($result_checkout)) {
                echo "<tr>";
                echo "<td>" . $row_checkout['ItemID'] . "</td>";
                echo "<td>" . $row_checkout['ItemType'] . "</td>";
                echo "<td>" . $row_checkout['Title'] . "</td>";
                echo "<td>" . $row_checkout['Author'] . "</td>";
                echo "<td>" . $row_checkout['CheckoutDate'] . "</td>";
                echo "<td>" . $row_checkout['ReturnDate'] . "</td>";
                echo "<td>" . $row_checkout['CheckinDate'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No checkout records found.</p>";
        }

        if (mysqli_num_rows($result_hold) > 0) {
            echo "<h3>Hold Records</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>HoldID</th>
                        <th>ItemID</th>
                        <th>ItemType</th>
                        <th>UserID</th>
                        <th>UserType</th>
                        <th>HoldDate</th>
                        <th>Status</th>
                    </tr>";

            while ($row_hold = mysqli_fetch_assoc($result_hold)) {
                echo "<tr>";
                echo "<td>" . $row_hold['HoldID'] . "</td>";
                echo "<td>" . $row_hold['ItemID'] . "</td>";
                echo "<td>" . $row_hold['ItemType'] . "</td>";
                echo "<td>" . $row_hold['UserID'] . "</td>";
                echo "<td>" . $row_hold['UserType'] . "</td>";
                echo "<td>" . $row_hold['HoldDate'] . "</td>";
                echo "<td>" . $row_hold['Status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No hold records found.</p>";
        }

        if (mysqli_num_rows($result_lost_items) > 0) {
            echo "<h3>Lost Items</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>LostItemID</th>
                        <th>ItemID</th>
                        <th>ItemType</th>
                        <th>UserID</th>
                        <th>UserType</th>
                        <th>LostDate</th>
                        <th>Status</th>
                    </tr>";

            while ($row_lost_item = mysqli_fetch_assoc($result_lost_items)) {
                echo "<tr>";
                echo "<td>" . $row_lost_item['LostID'] . "</td>";
                echo "<td>" . $row_lost_item['ItemID'] . "</td>";
                echo "<td>" . $row_lost_item['ItemType'] . "</td>";
                echo "<td>" . $row_lost_item['UserID'] . "</td>";
                echo "<td>" . $row_lost_item['UserType'] . "</td>";
                echo "<td>" . $row_lost_item['LostDate'] . "</td>";
                echo "<td>" . $row_lost_item['Fine'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No lost items found.</p>";
        }

        if (mysqli_num_rows($result_fines) > 0) {
            echo "<h3>Fines</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>FineID</th>
                        <th>UserID</th>
                        <th>Amount</th>
                        <th>FineDate</th>
                        <th>Status</th>
                    </tr>";

            while ($row_fine = mysqli_fetch_assoc($result_fines)) {
                echo "<tr>";
                echo "<td>" . $row_fine['FineID'] . "</td>";
                echo "<td>" . $row_fine['UserID'] . "</td>";
                echo "<td>" . $row_fine['FineAmount'] . "</td>";
                echo "<td>" . $row_fine['FineDate'] . "</td>";
                echo "<td>" . $row_fine['Status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No fines found.</p>";
        }

        mysqli_close($con);
    ?>
</body>
</html>
