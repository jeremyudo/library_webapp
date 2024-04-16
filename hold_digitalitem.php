<?php
session_start();

// Check if the UserID is set in the session
if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $userID = $_SESSION['StudentID'];
    
    // Perform database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // Get the digital item ID from the form submission
    if(isset($_POST['digitalid']) && !empty($_POST['digitalid'])) {
        $digitalID = $_POST['digitalid'];
        
        // Get the current date
        $holdDate = date("Y-m-d");
        
        // Insert the hold request into the holds table
        $queryInsert = "INSERT INTO holds (ItemID, ItemType, UserID, UserType, HoldDate) VALUES ('$digitalID', 'Digital Item', '$userID', 'Student', '$holdDate')";
        $resultInsert = mysqli_query($con, $queryInsert);
        
        if($resultInsert) {
            echo "<p>Hold request placed successfully!</p>";
        } else {
            echo "<p>Failed to place hold request.</p>";
        }
    } else {
        echo "<p>No digital item ID provided.</p>";
    }
    
    mysqli_close($con);
} else {
    echo "<p>User ID not found in the session.</p>";
}
?>
