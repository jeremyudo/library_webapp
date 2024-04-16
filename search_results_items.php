<?php
// Check if search term is provided
include 'navbar.php';
if(isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    
    // Perform database query to search for books and digital media items based on the provided search term
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');
    
    // Modify the SQL query to filter results based on search term
    $query = "SELECT Format, ISBN AS Identity, Title, Author, PublicationYear, Genre, Available FROM books WHERE (ISBN LIKE '%$searchTerm%' OR Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Format = 'Book') AND Title LIKE '%$searchTerm%'
            UNION
            SELECT Format, DigitalID AS Identity, Title, Author, PublicationYear, Genre, Available FROM digitalitems WHERE (DigitalID LIKE '%$searchTerm%' OR Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Format != 'Book') AND Title LIKE '%$searchTerm%'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        // Display search results in a table
        echo "<style>
        h2{
            font-family: 'Courier New', Courier, monospace;
            font-size: 30px;
            margin-bottom:8px;
            margin-top:20px;
        }
        .resultsTable {
            margin-top: 0;
            font-family: 'Courier New', Courier, monospace;
            width: 100%;
            border-collapse: collapse;
        }
        
        .resultsTable th,
        .resultsTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        .resultsTable th {
            background-color: #f2f2f2;
            text-align: left;
        }
        
        .resultsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .resultsTable tr:hover {
            background-color: #ddd;
        }
        
        .resultsTable a {
            text-decoration: none;
            color: #0366d6; /* You can change this to match your design */
        }
        
        .resultsTable a:hover {
            text-decoration: underline;
        }

        p{
            font-family: 'Courier New', Courier, monospace;
            font-size: 20px;
        }
        </style>";

        echo "<h2>Search Results</h2>";
        echo "<table class='resultsTable'>"; // Add class for the table
        echo "<tr><th>Title</th><th>Author</th><th>Identity</th><th>Year</th><th>Genre</th><th>Type</th><th>Available</th></tr>"; // Added <th> for Type
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // Modify the link URL based on Format
            if($row['Format'] == 'Book') {
                echo "<td><a href='details_book.php?isbn={$row['Identity']}'>{$row['Title']}</a></td>";
            } else {
                echo "<td><a href='details_digitalitem.php?digitalid={$row['Identity']}'>{$row['Title']}</a></td>";
            }
            echo "<td>{$row['Author']}</td>";
            echo "<td>{$row['Identity']}</td>";
            echo "<td>{$row['PublicationYear']}</td>";
            echo "<td>{$row['Genre']}</td>";
            echo "<td>{$row['Format']}</td>"; // Added <td> for Type
            echo "<td>{$row['Available']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No results found.</p>";
    }
    mysqli_close($con);
} else {
    echo "<p>No search term provided.</p>";
}
?>
<!-- Add a link back to the home page -->
<p><a href="home.php">Back to Home</a></p>
