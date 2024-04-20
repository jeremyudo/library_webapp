<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['accept'])) {
    if (isset($_POST['NotificationID'])) {
        $notificationID = $_POST['NotificationID'];

        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $query = "SELECT * FROM notifications WHERE NotificationID = $notificationID";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $notificationData = mysqli_fetch_assoc($result);
            $itemID = $notificationData['ItemID'];

            $studentID = $_SESSION['StudentID'];
            $checkoutDate = date("Y-m-d");
            $returnDate = date("Y-m-d", strtotime("+7 days"));

            $insertCheckoutQuery = "INSERT INTO checkouts (ItemID, ItemType, UserID, UserType, CheckoutDate, ReturnDate) VALUES ('$itemID', 'Book', '$studentID', 'Student', '$checkoutDate', '$returnDate')";
            $checkoutResult = mysqli_query($con, $insertCheckoutQuery);

            if ($checkoutResult) {
                $updateHoldQuery = "UPDATE holds SET Status = 'fulfilled' WHERE UserID = '$studentID' AND ItemID = '$itemID'";
                $updateHoldResult = mysqli_query($con, $updateHoldQuery);

                $updateNotificationQuery = "UPDATE notifications SET MarkedAsRead = true WHERE NotificationID = $notificationID";
                $updateNotificationResult = mysqli_query($con, $updateNotificationQuery);

                if ($updateHoldResult && $updateNotificationResult) {
                    echo "<p>Book checked out successfully!</p>";
                } else {
                    echo "<p>Failed to update hold status or mark notification as read.</p>";
                }
            } else {
                echo "<p>Failed to check out the book.</p>";
            }
        } else {
            echo "<p>Notification not found.</p>";
        }

        mysqli_close($con);
    } else {
        echo "<p>NotificationID not provided.</p>";
    }
} else {
    echo "<p>Accept button not clicked.</p>";
}

header("Location: view_notifications.php");
exit();
