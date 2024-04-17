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
        form{
            margin-left: 2rem;
        }

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
        
        button {
            margin-left: 0rem;
            margin-top: 1rem;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        p{
            margin-left: 2rem;
        }
    </style>

</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Digital Items</h2> 

    <!-- Filter Form -->
    <form method="get">
        <label for="filterBy">Filter By:</label>
        <select name="filterBy" id="filterBy">
            <option value="Title">Title</option>
            <option value="Author">Author/Artist</option>
            <option value="Format">Format</option>
            <option value="Publisher">Publisher/Studio</option>
            <!-- Add more options for other fields if needed -->
        </select>
        <input type="text" name="filterValue" placeholder="Filter Value">
        <button type="submit">Apply Filter</button>
    </form>

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // Prepare SQL query
        $sql = "SELECT * FROM digitalitems WHERE isDeleted = false";

        // Check if filter is provided
        if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
            $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
            $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
            $sql .= " AND $filterBy LIKE '%$filterValue%'";
        }

        // Execute SQL query
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
                echo "<td><a href='admin_view_digitalitem_report.php?digitalid=" . $row['DigitalID'] . "'>" . $row['DigitalID'] . "</a></td>";
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
            echo "<button onclick=\"location.href='update_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Update Digital Item</button>";
            echo "<button onclick=\"location.href='delete_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Delete Digital Item</button>";
        } else {
            echo "0 results";
        }

        // Close connection
        mysqli_close($con);
    ?>
    <p><a href="admin_home.php">Back</a></p>
</body>
</html>
