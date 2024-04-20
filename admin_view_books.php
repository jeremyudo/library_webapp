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
    <title>View Books</title>
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
        
        button {
            font-family: 'Courier New', Courier, monospace;
            margin-left: 1rem;
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

        .clickable {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        p{
            margin-left: 2rem;
        }
    </style>

</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Books</h2> 

    <!-- Filter Form -->
    <form method="get">
        <label for="filterBy">Filter By:</label>
        <select name="filterBy" id="filterBy">
            <option value="Title">Title</option>
            <option value="Author">Author</option>
            <option value="Genre">Genre</option>
            <option value="Language">Language</option>
        </select>
        <input type="text" name="filterValue" placeholder="Filter Value">
        <button type="submit">Apply Filter</button>
    </form>

    <?php
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM books";

        if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
            $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
            $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
            $sql .= " WHERE $filterBy LIKE '%$filterValue%'";
        }

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='resultsTable'>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Publication Year</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Cover Image</th>
                        <th>Stock</th>
                        <th>Available</th>
                        <th>Holds</th>
                        <th>Page Count</th>
                        <th>Format</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a class='clickable' href='admin_view_book_report.php?isbn=" . $row['ISBN'] . "'>" . $row['ISBN'] . "</a></td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Author'] . "</td>";
                echo "<td>" . $row['Publisher'] . "</td>";
                echo "<td>" . $row['PublicationYear'] . "</td>";
                echo "<td>" . $row['Genre'] . "</td>";
                echo "<td>" . $row['Language'] . "</td>";
                echo "<td>" . $row['CoverImage'] . "</td>";
                echo "<td>" . $row['Stock'] . "</td>";
                echo "<td>" . $row['Available'] . "</td>";
                echo "<td>" . $row['Holds'] . "</td>";
                echo "<td>" . $row['PageCount'] . "</td>";
                echo "<td>" . $row['Format'] . "</td>";
                echo "<td>" . $row['CreatedDate'] . "</td>";
                echo "<td>" . $row['UpdatedDate'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<button onclick=\"location.href='add_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Add Book</button>";
            echo "<button onclick=\"location.href='update_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Update Book</button>";
            echo "<button onclick=\"location.href='delete_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Delete Book</button>";
        } else {
            echo "0 results";
        }

        mysqli_close($con);
    ?>
    <p><a href="admin_home.php">Back</a></p>
</body>
</html>
