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

$userID = $_SESSION['StudentID'];
$sql = "SELECT NotificationID, ItemID, Message, NotificationType, TimeSent FROM notifications WHERE UserID = $userID AND MarkedAsRead = false ORDER BY TimeSent DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Notifications</title>
    <link rel="stylesheet" href="/account.css">
    <style>
        .notification {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .acknowledge-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="homeContent">
    <div class="accountTab">
        <a href="account.php">
            <div class="icon">
                <img src="/images/icon.png" alt="Icon">
            </div>
        </a>
    </div>
    <div class="logout">
        <a class="logoutText" href="logout.php">Logout</a>
    </div>
    <h1 class="welcome">Staff Notifications</h1>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='notification'>";
            echo "<p>Item ID: " . $row['ItemID'] . "</p>";
            echo "<p>" . $row['Message'] . "</p>";
            echo "<p>" . $row['NotificationType'] . "</p>";
            echo "<p class='timestamp'>" . $row['TimeSent'] . "</p>";
            echo "<form action='acknowledge_book_fine.php' method='post'>";
            echo "<input type='hidden' name='notification_id' value='" . $row['NotificationID'] . "'>";
            echo "<button type='submit' class='acknowledge-btn'>Acknowledge</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No unread notifications found.</p>";
    }
    mysqli_close($con);
    ?>
</div>
</body>
</html>
