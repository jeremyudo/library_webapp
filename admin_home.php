<?php
   // include 'navbar_admin.php';
   session_start();

   if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
       header("Location: admin_login.php");
       exit();
   }
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="admin_home.css">
   <title>Admin Panel</title>
</head>
<body>
<div class="accountTab">
      <a href="admin_home.php">
      <div class="icon">
        <img src="/images/icon.png" alt="Icon">
      </div>
      </a>
    </div>
    <div class="logout">
    <a class="logoutText" href="logout.php">Logout</a>
  </div>
   
   <h2>Admin Panel</h2> 
   <ul>
      <li><a href="admin_view_students.php">View All Students</a></li>
      <li><a href="admin_view_staff.php">View All Staff</a></li>
      <li><a href="admin_view_books.php">View All Books</a></li>
      <li><a href="admin_view_digitalitem.php">View All Digital Items</a></li>
      <li><a href="admin_view_holds.php">View All Holds</a></li>
      <li><a href="admin_view_events.php">View All Events</a></li>
      <li><a href="admin_data_report.php">Data Reports</a></li>
      <li><a href="admin_fine_data_report.php">Fine Data Reports</a></li>
      <li><a href="admin_hold_data_report.php">Hold Data Reports</a></li>
      <!-- <li><a href="admin_view_checkouts.php">View All Checkouts</a></li> -->
   </ul>
</body>
</html>
