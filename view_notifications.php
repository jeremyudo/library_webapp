<?php
include 'navbar.php';
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
<title>Notifications</title>
<link rel="stylesheet" href="/account.css">
</head>
<body>
<div class="homeContent">
<div class="accountTab">
      <div class="icon">
        <img src="/images/icon.png" alt="Icon">
        <style>
        .icon img {
              width: 50px;
            height: auto;  
        }
         </style>
      </div>
    </div>
    <div class="logout">
    <a class="logoutText" href="logout.php">Logout</a>
  </div>
  <h1 class="welcome">Notifications</h1>
  <?php
  if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
          echo "<div class='notification'>";
          echo "<a href='read_hold_notification.php?NotificationID=" . $row['NotificationID'] . "'>";
          echo "<p>Item ID: " . $row['ItemID'] . "</p>";
          echo "<p>" . $row['Message'] . "</p>";
          echo "</a>";
          echo "<p>" . $row['NotificationType'] . "</p>";
          echo "<p class='timestamp'>" . $row['TimeStamp'] . "</p>";
          echo "<form action='accept_hold_notification.php' method='post'>";
          echo "<input type='hidden' name='NotificationID' value='" . $row['NotificationID'] . "'>";
          echo "<button type='submit' name='accept'>Accept</button>";
          echo "</form>";
          echo "<form action='decline_hold_notification.php' method='post'>";
          echo "<input type='hidden' name='NotificationID' value='" . $row['NotificationID'] . "'>";
          echo "<button type='submit' name='decline'>Decline</button>";
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
