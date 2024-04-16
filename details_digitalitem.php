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
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Digital Item Details</title>
            <link rel='stylesheet' href='styles/MainPage.css'>
            <style>
            body {
                font-family: 'Courier New', Courier, monospace;
                background-color: #f5f5f5; /* Background color for the whole page */
                margin: 0;
                padding: 0;
            }

            .detailsContainer {
                max-width: 800px; /* Set the maximum width of the content area */
                margin: 20px auto; /* Center the content horizontally */
                padding: 20px;
                background-color: #fff; /* Background color for the content area */
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow effect */
            }

            h2 {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .detailsContainer p {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .detailsContainer strong {
                font-weight: bold;
            }

            .detailsContainer form {
                font-family: 'Courier New', Courier, monospace;
                margin-top: 20px;
            }
            

            .detailsContainer input[type='submit'] {
                font-family: 'Courier New', Courier, monospace;
                padding: 10px 20px;
                background-color: #4caf50; /* Button background color */
                color: #fff; /* Button text color */
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-right: 10px; /* Add right margin to create space between buttons */
            }

            .detailsContainer input[type='submit']:last-child {
                margin-right: 0; /* Remove margin from the last button */
            }

            .detailsContainer a {
                color: #007bff; /* Link color */
                text-decoration: none;
            }

            .detailsContainer a:hover {
                text-decoration: underline; /* Underline links on hover */
            }
            </style>
        </head>
        <body>
            <div class='detailsContainer'>
                ";

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

        echo "
            </div>
        </body>
        </html>
        ";
    } else {
        echo "<p>No details found for the provided digital item ID.</p>";
    }
    mysqli_close($con);
} else {
    echo "<p>No digital item ID provided.</p>";
}
?>
<!-- Add a link back to the home page -->
<p><a style="margin-left:320px;" href="home.php">Back to Home</a></p>
