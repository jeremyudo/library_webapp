<?php
    session_start();

    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: admin_login.php");
        exit();
    }

    if (!isset($_GET['isbn'])) {
        header("Location: admin_view_books.php");
        exit();
    }

    $isbn = $_GET['isbn'];

    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $sql_book = "SELECT * FROM books WHERE ISBN = '$isbn'";
    $result_book = mysqli_query($con, $sql_book);
    $book = mysqli_fetch_assoc($result_book);

    $sql_checkout_history = "SELECT c.*, s.FirstName, s.LastName
                             FROM checkouts c
                             INNER JOIN students s ON c.UserID = s.StudentID
                             WHERE c.ItemID = '$isbn' AND c.ItemType = 'Book'";
    $result_checkout_history = mysqli_query($con, $sql_checkout_history);

    $sql_hold_history = "SELECT h.*, s.FirstName, s.LastName
                         FROM holds h
                         INNER JOIN students s ON h.UserID = s.StudentID
                         WHERE h.ItemID = '$isbn' AND h.ItemType = 'Book'";
    $result_hold_history = mysqli_query($con, $sql_hold_history);

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
            margin: 1rem;
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
    <h2 style="margin-left:10rem; margin-top:5rem;">History for <?php echo $book['Title']; ?></h2> 

    <?php
        if (mysqli_num_rows($result_checkout_history) > 0) {
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

            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No checkout history found for this book.</p>";
        }

        if (mysqli_num_rows($result_hold_history) > 0) {
            echo "<h3 style='margin-left: 10rem;'>Hold History</h3>";
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Hold Date</th>
                        <th>Status</th>
                        <th>User ID</th>
                        <th>User Type</th>
                        <th>Student Name</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result_hold_history)) {
                echo "<tr>";
                echo "<td>" . $row['HoldDate'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['UserType'] . "</td>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No hold history found for this book.</p>";
        }

        if (mysqli_num_rows($result_fines) > 0) {
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

            echo "</table>";
        } else {
            echo "<p style='margin-left: 10rem;'>No fines found for this book.</p>";
        }

        mysqli_close($con);
    ?>
</body>
</html>
