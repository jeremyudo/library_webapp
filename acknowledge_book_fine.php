<?php
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$notificationID = $_POST['notification_id'];
$sql = "SELECT ItemID, NotificationType, UserID FROM staff_notifications WHERE NotificationID = $notificationID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$itemID = $row['ItemID'];
$notificationType = $row['NotificationType'];
$userID = $row['UserID'];
$userType = 'Student';
$fineDate = date('Y-m-d');
$status = 'Unpaid';

$fineAmount = ($notificationType === 'Book') ? 25 : 50;

$insertFineSQL = "INSERT INTO fines (ItemID, ItemType, UserID, UserType, FineAmount, FineDate, Status) 
                  VALUES ('$itemID', '$notificationType', '$userID', '$userType', '$fineAmount', '$fineDate', '$status')";
if (mysqli_query($con, $insertFineSQL)) {
    $staffID = $_SESSION['StudentID'];
    $updateNotificationSQL = "UPDATE staff_notifications SET MarkedAsRead = true, CompletedBy = '$staffID' WHERE NotificationID = $notificationID";
    if (mysqli_query($con, $updateNotificationSQL)) {
        echo "Fine added successfully.";
    } else {
        echo "Error updating notification: " . mysqli_error($con);
    }
} else {
    echo "Error adding fine: " . mysqli_error($con);
}

mysqli_close($con);
