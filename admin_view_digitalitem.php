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
    <title>View Digital Items</title>
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
    <h2 style="margin-left:10rem; margin-top:5rem;">View Digital Items</h2> 

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // SQL query to retrieve digital items where isDeleted is false
        $sql = "SELECT * FROM digitalitems WHERE isDeleted = false";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Start table
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Digital ID</th>
                        <th>Stock</th>
                        <th>Title</th>
                        <th>Author/Artist</th>
                        <th>Format</th>
                        <th>Publisher/Studio</th>
                        <th>Publication Year</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Cover Image</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                    </tr>";

            // Fetch and display each row of digital item information
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['DigitalID'] . "</td>";
                echo "<td>" . $row['Stock'] . "</td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Author'] . "</td>";
                echo "<td>" . $row['Format'] . "</td>";
                echo "<td>" . $row['Publisher'] . "</td>";
                echo "<td>" . $row['PublicationYear'] . "</td>";
                echo "<td>" . $row['Genre'] . "</td>";
                echo "<td>" . $row['Language'] . "</td>";
                echo "<td>" . $row['CoverImage'] . "</td>";
                echo "<td>" . $row['CreatedDate'] . "</td>";
                echo "<td>" . $row['UpdatedDate'] . "</td>";
                echo "</tr>";
            }

            // End table
            echo "</table>";
            echo "<button onclick=\"location.href='add_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Add Digital Item</button>";

            // Button to update digital item information
            echo "<button onclick=\"location.href='update_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Update Digital Item</button>";
            echo "<button onclick=\"location.href='delete_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Delete Digital Item</button>";
        } else {
            echo "0 results";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>