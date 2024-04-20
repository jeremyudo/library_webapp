<?php
session_start();

if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $userID = $_SESSION['StudentID'];

    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    if(isset($_POST['digitalid']) && !empty($_POST['digitalid'])) {
        $digitalID = $_POST['digitalid'];

        $returnDate = date("Y-m-d", strtotime("+7 days"));
        $checkoutDate = date("Y-m-d");

        $queryCheckAvailable = "SELECT Available FROM digitalitems WHERE DigitalID = '$digitalID'";
        $resultCheckAvailable = mysqli_query($con, $queryCheckAvailable);

        if(mysqli_num_rows($resultCheckAvailable) > 0) {
            $row = mysqli_fetch_assoc($resultCheckAvailable);
            $available = $row['Available'];

            if($available > 0) {
                $queryInsert = "INSERT INTO checkouts (ItemID, ItemType, UserID, UserType, CheckoutDate, ReturnDate) VALUES ('$digitalID', 'Digital Item', '$userID', 'Student', '$checkoutDate', '$returnDate')";
                $resultInsert = mysqli_query($con, $queryInsert);

                if($resultInsert) {
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
