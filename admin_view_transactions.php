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
    <title>View Transactions</title>
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
    <h2 style="margin-left:10rem; margin-top:5rem;">View All Transactions</h2> 

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // SQL query to retrieve unpaid fines
        $sql = "SELECT * FROM fines WHERE Status = 'Paid'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Start table
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Fine ID</th>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Fine Amount</th>
                        <th>Fine Date</th>
                        <th>Status</th>
                    </tr>";

            // Fetch and display each row of unpaid fine information
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['FineID'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['ItemID'] . "</td>";
                echo "<td>" . $row['ItemType'] . "</td>";
                echo "<td>" . $row['FineAmount'] . "</td>";
                echo "<td>" . $row['FineDate'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }

            // End table
            echo "</table>";
        } else {
            echo "No unpaid fines found";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
