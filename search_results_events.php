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
<title>View Events</title>
<link rel="stylesheet" href="styles/MainPage.css">
<link rel="stylesheet" href="styles/table.css"> 
</head>
<body>
<div class="homeContent">
  <h2>All Events</h2>
  <?php
  $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
  if (!$con) {
      die('Could not connect: ' . mysqli_connect_error());
  }
  mysqli_select_db($con, 'library');

  $query = "SELECT * FROM events";
  $result = mysqli_query($con, $query);

  if(mysqli_num_rows($result) > 0) {
      echo "<table class='resultsTable'>";
      echo "<tr><th>Event Name</th><th>Date</th><th>Start Time</th><th>End Time</th><th>Location</th><th>Categories</th><th>Description</th><th>Type</th><th>Max Attendees</th></tr>";
      while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td><a href='details_event.php?event_id={$row['EventID']}'>{$row['EventName']}</a></td>";
          echo "<td>{$row['Date']}</td>";
          echo "<td>{$row['StartTime']}</td>";
          echo "<td>{$row['EndTime']}</td>";
          echo "<td>{$row['Location']}</td>";
          echo "<td>{$row['Categories']}</td>";
          echo "<td>{$row['Description']}</td>";
          echo "<td>{$row['Type']}</td>";
          echo "<td>{$row['MaxAttendees']}</td>";
          echo "</tr>";
      }
      echo "</table>";
  } else {
      echo "<p>No events found.</p>";
  }

  mysqli_close($con);
  ?>
  <p><a href="home.php">Back to Home</a></p>
</div>
</body>
</html>
