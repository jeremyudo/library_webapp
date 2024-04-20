<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['NotificationID'])) {
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    
    $notificationID = $_POST['NotificationID'];
    
    $updateNotificationQuery = "UPDATE notifications SET MarkedAsRead = true WHERE NotificationID = $notificationID";
    $updateNotificationResult = mysqli_query($con, $updateNotificationQuery);
    
    if ($updateNotificationResult) {
        $updateHoldQuery = "UPDATE holds SET Status = 'canceled' WHERE HoldID = $notificationID";
        $updateHoldResult = mysqli_query($con, $updateHoldQuery);
        
        if ($updateHoldResult) {
            echo "<p>Notification declined successfully.</p>";
        } else {
            echo "<p>Error updating hold status.</p>";
        }
    } else {
        echo "<p>Error marking notification as read.</p>";
    }
    
    mysqli_close($con);
} else {
    echo "<p>NotificationID not provided.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
