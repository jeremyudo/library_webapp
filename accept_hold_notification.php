<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted with the accept button
if (isset($_POST['accept'])) {
    // Check if NotificationID is set
    if (isset($_POST['NotificationID'])) {
        $notificationID = $_POST['NotificationID'];

        // Perform database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // Retrieve notification details from the database
        $query = "SELECT * FROM notifications WHERE NotificationID = $notificationID";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $notificationData = mysqli_fetch_assoc($result);
            $itemID = $notificationData['ItemID'];

            // Checkout the book
            $studentID = $_SESSION['StudentID'];
            $checkoutDate = date("Y-m-d");
            $returnDate = date("Y-m-d", strtotime("+7 days"));

            $insertCheckoutQuery = "INSERT INTO checkouts (ItemID, ItemType, UserID, UserType, CheckoutDate, ReturnDate) VALUES ('$itemID', 'Book', '$studentID', 'Student', '$checkoutDate', '$returnDate')";
            $checkoutResult = mysqli_query($con, $insertCheckoutQuery);

            if ($checkoutResult) {
                // Update hold status to "fulfilled"
                $updateHoldQuery = "UPDATE holds SET Status = 'fulfilled' WHERE UserID = '$studentID' AND ItemID = '$itemID'";
                $updateHoldResult = mysqli_query($con, $updateHoldQuery);

                // Mark the notification as read
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

        // Close database connection
        mysqli_close($con);
    } else {
        echo "<p>NotificationID not provided.</p>";
    }
} else {
    echo "<p>Accept button not clicked.</p>";
}

// Redirect back to the notifications page
header("Location: view_notifications.php");
exit();
?>
