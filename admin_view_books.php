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
    <title>View Books</title>
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
        
        button {
            font-family: 'Courier New', Courier, monospace;
            margin-left: 1rem;
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
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Books</h2> 

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // SQL query to retrieve all books
        $sql = "SELECT * FROM books";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Start table
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

            // Fetch and display each row of book information
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ISBN'] . "</td>";
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

            // End table
            echo "</table>";
            echo "<button onclick=\"location.href='add_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Add Book</button>";

            // Button to update book information
            echo "<button onclick=\"location.href='update_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Update Book</button>";
            echo "<button onclick=\"location.href='delete_book.php'\" style=\"margin-left:10rem; margin-top:1rem;\">Delete Book</button>";
        } else {
            echo "0 results";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
