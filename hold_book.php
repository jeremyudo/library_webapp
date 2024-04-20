<?php
session_start();

if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];
    
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    if(isset($_POST['isbn']) && !empty($_POST['isbn'])) {
        $isbn = $_POST['isbn'];
        
        $holdDate = date("Y-m-d");
        
        $queryInsert = "INSERT INTO holds (ItemID, ItemType, UserID, UserType, HoldDate) VALUES ('$isbn', 'Book', '$studentId', 'Student', '$holdDate')";
        $resultInsert = mysqli_query($con, $queryInsert);
        
        if($resultInsert) {
            echo "<p>Hold request placed successfully!</p>";
        } else {
            echo "<p>Failed to place hold request.</p>";
        }
    } else {
        echo "<p>No ISBN provided.</p>";
    }
    
    mysqli_close($con);
} else {
    echo "<p>Student ID not found in the session.</p>";
}
?>
