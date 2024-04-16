<?php
// Check if digital item ID is provided in the URL
if(isset($_GET['digitalid'])) {
    $digitalID = $_GET['digitalid'];
    
    // Perform database query to retrieve details of the digital item
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');
    
    $query = "SELECT Title, Author, DigitalID, PublicationYear, Description, Genre, Language, Format, Available FROM digitalitems WHERE DigitalID = '$digitalID'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        // Display details of the digital item
        $row = mysqli_fetch_assoc($result);
        echo "<h2>Digital Item Details</h2>";
        echo "<p><strong>Title:</strong> {$row['Title']}</p>";
        echo "<p><strong>Author:</strong> {$row['Author']}</p>";
        echo "<p><strong>Digital ID:</strong> {$row['DigitalID']}</p>";
        echo "<p><strong>Publication Year:</strong> {$row['PublicationYear']}</p>";
        echo "<p><strong>Description:</strong> {$row['Description']}</p>";
        echo "<p><strong>Genre:</strong> {$row['Genre']}</p>";
        echo "<p><strong>Language:</strong> {$row['Language']}</p>";
        echo "<p><strong>Format:</strong> {$row['Format']}</p>";
        echo "<p><strong>Available Copies:</strong> {$row['Available']}</p>";
        
        // Add buttons for checking out, checking in, and holding
        echo "<form action='checkout_digitalitem.php' method='post'>";
        echo "<input type='hidden' name='digitalid' value='$digitalID'>";
        echo "<input type='submit' name='checkout' value='Check Out'>";
        echo "</form>";
        
        echo "<form action='checkin_digitalitem.php' method='post'>";
        echo "<input type='hidden' name='digitalid' value='$digitalID'>";
        echo "<input type='submit' name='checkin' value='Check In'>";
        echo "</form>";
        
        echo "<form action='hold_digitalitem.php' method='post'>";
        echo "<input type='hidden' name='digitalid' value='$digitalID'>";
        echo "<input type='submit' name='hold' value='Hold'>";
        echo "</form>";
    } else {
        echo "<p>No details found for the provided digital item ID.</p>";
    }
    mysqli_close($con);
} else {
    echo "<p>No digital item ID provided.</p>";
}
?>
<!-- Add a link back to the home page -->
<p><a href="home.php">Back to Home</a></p>
