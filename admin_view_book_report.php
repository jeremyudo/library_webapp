<?php
    // Start session
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Redirect to admin login page if not logged in
        header("Location: admin_login.php");
        exit();
    }

    // Check if ISBN is provided in the URL
    if (!isset($_GET['isbn'])) {
        // Redirect back to the view books page if ISBN is not provided
        header("Location: admin_view_books.php");
        exit();
    }

    // Get ISBN from URL parameter
    $isbn = $_GET['isbn'];

    // Database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // SQL query to retrieve book information
    $sql_book = "SELECT * FROM books WHERE ISBN = '$isbn'";
    $result_book = mysqli_query($con, $sql_book);
    $book = mysqli_fetch_assoc($result_book);

    // SQL query to retrieve checkout history for the book
    $sql_checkout_history = "SELECT c.*, s.FirstName, s.LastName
                             FROM checkouts c
                             INNER JOIN students s ON c.UserID = s.StudentID
                             WHERE c.ItemID = '$isbn' AND c.ItemType = 'Book'";
    $result_checkout_history = mysqli_query($con, $sql_checkout_history);

    // SQL query to retrieve hold history for the book
    $sql_hold_history = "SELECT h.*, s.FirstName, s.LastName
                         FROM holds h
                         INNER JOIN students s ON h.UserID = s.StudentID
                         WHERE h.ItemID = '$isbn' AND h.ItemType = 'Book'";
    $result_hold_history = mysqli_query($con, $sql_hold_history);

    // SQL query to retrieve fines associated with the book
    $sql_fines = "SELECT f.*
                  FROM fines f
                  WHERE f.ItemID = '$isbn' AND f.ItemType = 'Book'";
    $result_fines = mysqli_query($con, $sql_fines);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Report</title>
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
            margin: 1rem; /* Center the table */
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
    <h2 style="margin-left:10rem; margin-top:5rem;">History for <?php echo $book['Title']; ?></h2> 

    <?php
        // Display book information
        // echo "<p style='margin-left: 10rem;'>ISBN: " . $book['ISBN'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Title: " . $book['Title'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Author: " . $book['Author'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Publisher: " . $book['Publisher'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Publication Year: " . $book['PublicationYear'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Genre: " . $book['Genre'] . "</p>";
        // echo "<p style='margin-left: 10rem;'>Language: " . $book['Language'] . "</p>";

        // Display checkout history
        if (mysqli_num_rows($result_checkout_history) > 0) {
            // Start table for checkout history
            echo "<h3 style='margin-left: 10rem;'>Checkout History</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Checkout Date</th>
                        <th>Return Date</th>
                        <th>Check-in Date</th>
                        <th>User ID</th>
                        <th>User Type</th>
                        <th>Student Name</th>
                    </tr>";

            // Fetch and display each row of checkout history
            while ($row = mysqli_fetch_assoc($result_checkout_history)) {
                echo "<tr>";
                echo "<td>" . $row['CheckoutDate'] . "</td>";
                echo "<td>" . $row['ReturnDate'] . "</td>";
                echo "<td>" . $row['CheckinDate'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['UserType'] . "</td>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "</tr>";
            }

            // End table for checkout history
            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No checkout history found for this book.</p>";
        }

        // Display hold history
        if (mysqli_num_rows($result_hold_history) > 0) {
            // Start table for hold history
            echo "<h3 style='margin-left: 10rem;'>Hold History</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Hold Date</th>
                        <th>Status</th>
                        <th>User ID</th>
                        <th>User Type</th>
                        <th>Student Name</th>
                    </tr>";

            // Fetch and display each row of hold history
            while ($row = mysqli_fetch_assoc($result_hold_history)) {
                echo "<tr>";
                echo "<td>" . $row['HoldDate'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['UserType'] . "</td>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "</tr>";
            }

            // End table for hold history
            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No hold history found for this book.</p>";
        }

        // Display fines
        if (mysqli_num_rows($result_fines) > 0) {
            // Start table for fines
            echo "<h3 style='margin-left: 10rem;'>Fines</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Fine ID</th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>User ID</th>
                        <th>User Type</th>
                        <th>Fine Amount</th>
                        <th>Fine Date</th>
                        <th>Status</th>
                    </tr>";

            // Fetch and display each row of fines
            while ($row = mysqli_fetch_assoc($result_fines)) {
                echo "<tr>";
                echo "<td>" . $row['FineID'] . "</td>";
                echo "<td>" . $row['ItemID'] . "</td>";
                echo "<td>" . $row['ItemType'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['UserType'] . "</td>";
                echo "<td>" . $row['FineAmount'] . "</td>";
                echo "<td>" . $row['FineDate'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }

            // End table for fines
            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No fines found for this book.</p>";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
