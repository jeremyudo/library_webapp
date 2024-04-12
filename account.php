<?php
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account</title>
<link rel="stylesheet" href="styles/MainPage.css">
</head>
<body>
<div class="homeContent">
  <h1 class="welcome">Welcome to Your Account, <?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName']; ?></h1>
  <!-- Add a link to view checkouts -->
  <p><a href="view_checkouts.php">View Checkouts</a></p>
  <!-- Add a link to view holds -->
  <p><a href="view_holds.php">View Holds</a></p>
  <!-- Add a link to view history -->
  <p><a href="history.php">History</a></p>
  <!-- Add other content of the account page as needed -->
  <div class="logout">
    <a href="logout.php">Logout</a>
  </div>
</div>
</body>
</html>
