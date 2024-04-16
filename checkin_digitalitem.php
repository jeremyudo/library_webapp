<?php
session_start(); // Start or resume the session

// Check if the UserID is set in the session
if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $userID = $_SESSION['StudentID'];
    
    // Perform database query to update checkout record
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');
    
    // Get the digital item ID from the form submission
    if(isset($_POST['digitalid']) && !empty($_POST['digitalid'])) {
        $digitalID = $_POST['digitalid'];
        
        // Update the CheckInDate column in the checkouts table
        $checkInDate = date("Y-m-d");
        $queryUpdate = "UPDATE checkouts 
                        SET CheckInDate = '$checkInDate' 
                        WHERE ItemID = '$digitalID' AND ItemType = 'Digital Item' AND UserID = '$userID' AND CheckInDate IS NULL
                        ORDER BY CheckoutDate ASC
                        LIMIT 1";
        $resultUpdate = mysqli_query($con, $queryUpdate);
        
        if($resultUpdate) {
            // Increment the available column in the digitalitems table
            $queryUpdateAvail = "UPDATE digitalitems SET Available = Available + 1 WHERE DigitalID = '$digitalID'";
            $resultUpdateAvail = mysqli_query($con, $queryUpdateAvail);
            
            if($resultUpdateAvail) {
                echo "<p>Digital item checked in successfully!</p>";
            } else {
                echo "<p>Failed to update digital item availability.</p>";
            }
        } else {
            echo "<p>Failed to check in the digital item.</p>";
        }
    } else {
        echo "<p>No digital item ID provided.</p>";
    }
    
    mysqli_close($con);
} else {
    echo "<p>User ID not found in the session.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
