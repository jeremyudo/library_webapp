<?php
   // Start session
   session_start();

   // Check if staff is logged in
   if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
       // Redirect to staff login page if not logged in
       header("Location: staff_login.php");
       exit();
   }
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="admin_home.css">
   <title>Staff Panel</title>
</head>
<body>
   <div class="accountTab">
      <a href="staff_home.php">
      <div class="icon">
        <img src="/images/icon.png" alt="Icon">
      </div>
      </a>
    </div>
    <div class="logout">
    <a class="logoutText" href="logout.php">Logout</a>
  </div>
   
   <h2 style="margin-left:10rem; margin-top:5rem;">Staff Panel</h2> 
   <ul style="list-style-type:none; margin-left:10rem;">
        <li><a href="view_staff_notifications.php">Notifications</a></li>
      <li><a href="admin_view_students.php">View All Students</a></li>
      <li><a href="admin_view_books.php">View All Books</a></li>
      <li><a href="admin_view_digitalitem.php">View All Digital Items</a></li>
      <li><a href="admin_view_holds.php">View All Holds</a></li>
      <li><a href="admin_view_checkouts.php">View All Checkouts</a></li>
   </ul>
</body>
</html>
