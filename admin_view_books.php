<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            font-size: 25px;
            color: #333;
            margin: 20px 0;
        }

        .container {
            width: 90%;
            max-width: 1400px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin: 20px;
        }

        .resultsTable {
            font-size: 12px;
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        .resultsTable th {
            background-color: #f9f9f9;
            color: #333;
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Books</h2> 

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
                echo "<button onclick=\"location.href='add_book.php'\" style=\"margin-left:1rem; margin-top:1rem;\">Add Book</button>";

                // Button to update book information
                echo "<button onclick=\"location.href='update_book.php'\" style=\"margin-left:2rem; margin-top:1rem;\">Update Book</button>";
                echo "<button onclick=\"location.href='delete_book.php'\" style=\"margin-left:2rem; margin-top:1rem;\">Delete Book</button>";
            } else {
                echo "0 results";
            }

            // Close connection
            mysqli_close($con);
        ?>
    </div>
</body>
</html>
