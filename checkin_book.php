<?php
session_start();

if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];

    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');

    if(isset($_POST['isbn']) && !empty($_POST['isbn'])) {
        $isbn = $_POST['isbn'];

        $checkInDate = date("Y-m-d");
        $queryUpdate = "UPDATE checkouts 
                        SET CheckInDate = '$checkInDate' 
                        WHERE ItemID = '$isbn' AND UserID = '$studentId' AND CheckInDate IS NULL
                        ORDER BY CheckoutDate ASC, CheckOutID ASC
                        LIMIT 1";
        $resultUpdate = mysqli_query($con, $queryUpdate);

        if($resultUpdate) {
            $queryUpdateAvail = "UPDATE books SET available = available + 1 WHERE ISBN = '$isbn'";
            $resultUpdateAvail = mysqli_query($con, $queryUpdateAvail);

            if($resultUpdateAvail) {
                echo "<p>Book checked in successfully!</p>";
            } else {
                echo "<p>Failed to update book availability.</p>";
            }
        } else {
            echo "<p>Failed to check in the book.</p>";
        }
    } else {
        echo "<p>No ISBN provided.</p>";
    }

    mysqli_close($con);
} else {
    echo "<p>Student ID not found in the session.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
