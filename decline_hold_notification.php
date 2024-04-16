<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if NotificationID is set
if (isset($_POST['NotificationID'])) {
    // Connect to the database
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    
    // Retrieve NotificationID from the form
    $notificationID = $_POST['NotificationID'];
    
    // Update notifications table to mark the notification as read
    $updateNotificationQuery = "UPDATE notifications SET MarkedAsRead = true WHERE NotificationID = $notificationID";
    $updateNotificationResult = mysqli_query($con, $updateNotificationQuery);
    
    // Check if the notification was marked as read successfully
    if ($updateNotificationResult) {
        // Update holds table to mark the hold status as canceled
        $updateHoldQuery = "UPDATE holds SET Status = 'canceled' WHERE HoldID = $notificationID";
        $updateHoldResult = mysqli_query($con, $updateHoldQuery);
        
        // Check if the hold status was updated successfully
        if ($updateHoldResult) {
            echo "<p>Notification declined successfully.</p>";
        } else {
            echo "<p>Error updating hold status.</p>";
        }
    } else {
        echo "<p>Error marking notification as read.</p>";
    }
    
    // Close database connection
    mysqli_close($con);
} else {
    echo "<p>NotificationID not provided.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
