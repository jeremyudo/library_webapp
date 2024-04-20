<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = $_POST['itemID'];
    $studentID = $_SESSION['StudentID'];

    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');

    $check_item_sql = "SELECT * FROM checkouts WHERE ItemID = '$itemID' AND UserID = '$studentID'";
    $result = mysqli_query($con, $check_item_sql);
    if (!$result) {
        die('Error checking item: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
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
        
        $update_checkin_sql = "UPDATE checkouts SET CheckinDate = NOW() WHERE ItemID = '$itemID' AND UserID = '$studentID' AND CheckinDate IS NULL";
        if (!mysqli_query($con, $update_checkin_sql)) {
            die('Error updating CheckinDate: ' . mysqli_error($con));
        }

        echo "Item marked as lost successfully.";
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 1000);
              </script>";
        exit();
    } else {
        echo "Error: Item not checked out by the current user.";
    }

    mysqli_close($con);
}
?>
