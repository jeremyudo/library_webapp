<?php
// Check if search term is provided
if(isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    
    // Perform database query to search for books and digital media items based on the provided search term
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');
    
    $query = "SELECT Format, ISBN AS Identity, Title, Author, PublicationYear, Genre, Available FROM books WHERE ISBN LIKE '%$searchTerm%' OR Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Format = 'Book'
            UNION
            SELECT Format, DigitalID AS Identity, Title, Author, PublicationYear, Genre, Available FROM digitalitems WHERE DigitalID LIKE '%$searchTerm%' OR Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Format != 'Book'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        // Display search results in a table
        echo "<h2>Search Results</h2>";
        echo "<table class='resultsTable'>"; // Add class for the table
        echo "<tr><th>Title</th><th>Author</th><th>Identity</th><th>Year</th><th>Genre</th><th>Available</th></tr>";
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
