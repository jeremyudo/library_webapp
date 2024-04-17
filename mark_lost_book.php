<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the itemID and studentID from the form
    $itemID = $_POST['itemID'];
    $studentID = $_SESSION['StudentID'];

    // Establish database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');

    // Check if the item is checked out by the student
    $check_item_sql = "SELECT * FROM checkouts WHERE ItemID = '$itemID' AND UserID = '$studentID'";
    $result = mysqli_query($con, $check_item_sql);
    if (!$result) {
        die('Error checking item: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
        // The item is checked out by the student, insert a record into the lostitems table
        $insert_lost_sql = "INSERT INTO lostitems (ItemID, ItemType, UserID, UserType, LostDate, Fine) 
                    SELECT '$itemID', ItemType, '$studentID', 'Student', NOW(),
                           CASE 
                               WHEN ItemType = 'Book' THEN 25
                               ELSE 50
                           END
                    FROM checkouts 
                    WHERE ItemID = '$itemID' AND UserID = '$studentID'
                    LIMIT 1";
        if (!mysqli_query($con, $insert_lost_sql)) {
            die('Error marking item as lost: ' . mysqli_error($con));
        }
        
        // Update CheckinDate in checkouts table
        $update_checkin_sql = "UPDATE checkouts SET CheckinDate = NOW() WHERE ItemID = '$itemID' AND UserID = '$studentID' AND CheckinDate IS NULL";
        if (!mysqli_query($con, $update_checkin_sql)) {
            die('Error updating CheckinDate: ' . mysqli_error($con));
        }

        echo "Item marked as lost successfully.";
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 1000); // 1 second delay
              </script>";
        exit(); // Exit to prevent further output
    } else {
        echo "Error: Item not checked out by the current user.";
    }

    // Close connection
    mysqli_close($con);
}
?>
