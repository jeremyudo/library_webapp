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
    <title>View Digital Items</title>
    <style>
        form{
            margin-left: 2rem;
        }

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
        
        button {
            margin-left: 0rem;
            margin-top: 1rem;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
        }

        button:hover {
            background-color: #45a049;
        }

        p{
            margin-left: 2rem;
        }
    </style>

</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Digital Items</h2> 

    <form method="get">
        <label for="filterBy">Filter By:</label>
        <select name="filterBy" id="filterBy">
            <option value="Title">Title</option>
            <option value="Author">Author/Artist</option>
            <option value="Format">Format</option>
            <option value="Publisher">Publisher/Studio</option>
        </select>
        <input type="text" name="filterValue" placeholder="Filter Value">
        <button type="submit">Apply Filter</button>
    </form>

    <?php
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM digitalmediaitem WHERE NoLongerCarried = 0";

        if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
            $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
            $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
            $sql .= " AND $filterBy LIKE '%$filterValue%'";
        }

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Digital ID</th>
                        <th>Stock</th>
                        <th>Title</th>
                        <th>Author/Artist</th>
                        <th>Format</th>
                        <th>Publisher/Studio</th>
                        <th>Description</th>
                        <th>Language</th>
                        <th>Cover Image</th>
                        <th>Available</th>
                        <th>Checked Out</th>
                        <th>Holds</th>
                        <th>Lost/Damaged</th>
                        <th>Cost</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='admin_view_digitalitem_report.php?digitalid=" . $row['DigiID'] . "'>" . $row['DigiID'] . "</a></td>";
                echo "<td>" . $row['Stock'] . "</td>";
                echo "<td>" . $row['MediaName'] . "</td>";
                echo "<td>" . $row['Producer'] . "</td>";
                echo "<td>" . $row['Format'] . "</td>";
                echo "<td>" . $row['Publisher'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Language'] . "</td>";
                echo "<td>" . $row['CoverImageURL'] . "</td>";
                echo "<td>" . $row['NumberAvailable'] . "</td>";
                echo "<td>" . $row['NumberCheckedOut'] . "</td>";
                echo "<td>" . $row['NumberHeld'] . "</td>";
                echo "<td>" . $row['Lost/Damaged'] . "</td>";
                echo "<td>" . $row['Cost'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<button onclick=\"location.href='add_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Add Digital Item</button>";
            echo "<button onclick=\"location.href='update_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Update Digital Item</button>";
            echo "<button onclick=\"location.href='delete_digitalitem.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Delete Digital Item</button>";
        } else {
            echo "0 results";
        }

        mysqli_close($con);
    ?>
    <p><a href="admin_home.php">Back</a></p>
</body>
</html>
