<?php
   // Start session
   session_start();

   // Check if admin is logged in
   if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
       // Redirect to admin login page if not logged in
       header("Location: admin_login.php");
       exit();
   }
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
</head>
<body>
   <h2 style="margin-left:10rem; margin-top:5rem;">Admin Panel</h2> 
   <ul style="list-style-type:none; margin-left:10rem;">
      <li><a href="admin_view_students.php">View All Students</a></li>
      <li><a href="view_faculty.php">View All Faculty</a></li>
      <li><a href="view_librarians.php">View All Librarians</a></li>
      <li><a href="view_books.php">View All Books</a></li>
      <li><a href="view_digital_items.php">View All Digital Items</a></li>
      <li><a href="view_holds.php">View All Holds</a></li>
      <li><a href="view_events.php">View All Events</a></li>
      <li><a href="view_checkouts.php">View All Checkouts</a></li>
   </ul>
</body>
</html>
