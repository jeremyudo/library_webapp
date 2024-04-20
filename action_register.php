<?php
session_start();

if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];
    
    if(isset($_POST['EventID']) && !empty($_POST['EventID'])) {
        $eventId = $_POST['EventID'];
        
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }
        
        $queryCheckEvent = "SELECT * FROM events WHERE EventID = '$eventId' AND MaxAttendees > Attendees";
        $resultCheckEvent = mysqli_query($con, $queryCheckEvent);
        
        if(mysqli_num_rows($resultCheckEvent) > 0) {
            $queryIncrementAttendees = "UPDATE events SET Attendees = Attendees + 1 WHERE EventID = '$eventId'";
            $resultIncrementAttendees = mysqli_query($con, $queryIncrementAttendees);
            
            if($resultIncrementAttendees) {
                echo "<p>Successfully registered for the event!</p>";
            } else {
                echo "<p>Failed to register for the event.</p>";
            }
        } else {
            echo "<p>The event is full or no longer available for registration.</p>";
        }
        
        mysqli_close($con);
    } else {
        echo "<p>No event ID provided.</p>";
    }
} else {
    echo "<p>Student ID not found in the session.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
