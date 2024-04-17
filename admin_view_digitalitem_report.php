<?php
    // Start session
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Redirect to admin login page if not logged in
        header("Location: admin_login.php");
        exit();
    }

    // Check if DigitalID is provided in the URL
    if (!isset($_GET['digitalid'])) {
        // Redirect back to the view digital items page if DigitalID is not provided
        header("Location: admin_view_digitalitems.php");
        exit();
    }

    // Get DigitalID from URL parameter
    $digitalID = $_GET['digitalid'];

    // Database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // SQL query to retrieve digital item information
    $sql_digital = "SELECT * FROM digitalitems WHERE DigitalID = '$digitalID'";
    $result_digital = mysqli_query($con, $sql_digital);
    $digital_item = mysqli_fetch_assoc($result_digital);

    // SQL query to retrieve checkout history for the digital item
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
            margin-left: 1rem; /* Center the table */
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
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">Digital Item Details</h2> 

    <?php
        // Display digital item information
        echo "<p style='margin-left: 10rem;'>Digital ID: " . $digital_item['DigitalID'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Stock: " . $digital_item['Stock'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Title: " . $digital_item['Title'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Author/Artist: " . $digital_item['Author'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Format: " . $digital_item['Format'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Publisher/Studio: " . $digital_item['Publisher'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Publication Year: " . $digital_item['PublicationYear'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Genre: " . $digital_item['Genre'] . "</p>";
        echo "<p style='margin-left: 10rem;'>Language: " . $digital_item['Language'] . "</p>";

        // Display checkout history
        if (mysqli_num_rows($result_checkout_history) > 0) {
            // Start table for checkout history
            echo "<h3 style='margin-left: 10rem;'>Checkout History</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Checkout Date</th>
                        <th>Return Date</th>
                        <th>Checkin Date</th>
                        <th>User ID</th>
                        <th>Student Name</th>
                    </tr>";

            // Fetch and display each row of checkout history
            while ($row = mysqli_fetch_assoc($result_checkout_history)) {
                echo "<tr>";
                echo "<td>" . $row['CheckoutDate'] . "</td>";
                echo "<td>" . $row['ReturnDate'] . "</td>";
                echo "<td>" . $row['CheckinDate'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "</tr>";
            }

            // End table for checkout history
            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No checkout history found for this digital item.</p>";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
