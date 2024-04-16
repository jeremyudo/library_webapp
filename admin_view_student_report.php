<?php
    // Start session
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Redirect to admin login page if not logged in
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
        /* CSS for table styles */
        .resultsTable {
            border-collapse: collapse; /* Collapse borders to avoid double borders */
            width: 100%; /* Full width */
        }
        
        .resultsTable th, .resultsTable td {
            border: 1px solid black; /* Add black borders to cells */
            padding: 8px; /* Add some padding for better spacing */
            text-align: left; /* Align text to the left */
        }
        
        .resultsTable th {
            background-color: #f2f2f2; /* Light gray background color for header cells */
        }
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Student Report</h2> 

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // Get the student ID from the URL parameter
        $studentID = $_GET['student_id'];

        // SQL query to retrieve checkout records for the student
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

        // SQL query to retrieve hold records for the student
        $sql_hold = "SELECT * FROM holds WHERE UserID = '$studentID'";
        $result_hold = mysqli_query($con, $sql_hold);

        // Display checkout records
        if (mysqli_num_rows($result_checkout) > 0) {
            // Start table for checkout records
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

            // Fetch and display each row of checkout records
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

            // End table for checkout records
            echo "</table>";
        } else {
            echo "<p>No checkout records found.</p>";
        }

        // Display hold records
        if (mysqli_num_rows($result_hold) > 0) {
            // Start table for hold records
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

            // Fetch and display each row of hold records
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

            // End table for hold records
            echo "</table>";
        } else {
            echo "<p>No hold records found.</p>";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
