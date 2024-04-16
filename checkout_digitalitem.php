<?php
session_start(); // Start or resume the session

// Check if the UserID is set in the session
if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $userID = $_SESSION['StudentID'];
    
    // Perform database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // Continue with the checkout process
    if(isset($_POST['digitalid']) && !empty($_POST['digitalid'])) {
        $digitalID = $_POST['digitalid'];
        
        // Calculate the return date (7 days from now)
        $returnDate = date("Y-m-d", strtotime("+7 days"));
        
        // Get the current date
        $checkoutDate = date("Y-m-d");
        
        // Check if the digital item is available
        $queryCheckAvailable = "SELECT Available FROM digitalitems WHERE DigitalID = '$digitalID'";
        $resultCheckAvailable = mysqli_query($con, $queryCheckAvailable);

        if(mysqli_num_rows($resultCheckAvailable) > 0) {
            $row = mysqli_fetch_assoc($resultCheckAvailable);
            $available = $row['Available'];
            
            if($available > 0) {
                // Insert the checkout record into the checkouts table
                $queryInsert = "INSERT INTO checkouts (ItemID, ItemType, UserID, UserType, CheckoutDate, ReturnDate) VALUES ('$digitalID', 'Digital Item', '$userID', 'Student', '$checkoutDate', '$returnDate')";
                $resultInsert = mysqli_query($con, $queryInsert);
                
                if($resultInsert) {
                    // Decrement the available column in the digitalitems table
                    $queryUpdate = "UPDATE digitalitems SET Available = Available - 1 WHERE DigitalID = '$digitalID'";
                    $resultUpdate = mysqli_query($con, $queryUpdate);
                    
                    if($resultUpdate) {
                        echo "<p>Digital item checked out successfully!</p>";
                    } else {
                        echo "<p>Failed to update digital item availability.</p>";
                    }
                } else {
                    echo "<p>Failed to check out the digital item.</p>";
                }
            } else {
                echo "<p>The digital item is no longer available for checkout.</p>";
            }
        } else {
            echo "<p>Digital item not found.</p>";
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
