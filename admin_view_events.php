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
<title>View Events and Attendees</title>
<style>
.resultsTable {
    border-collapse: collapse;
    width: 100%;
}

.resultsTable th, .resultsTable td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
    font-family: 'Courier New', Courier, monospace;
}

.resultsTable th {
    background-color: #f2f2f2;
}

body {
    font-family: 'Courier New', Courier, monospace;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
}

.homeContent {
    width: 90%;
    margin: auto;
    padding: 20px;
    border-radius: 8px;
}

h2 {
    margin-bottom: 20px;
}

a {
    color: #4A90E2;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>

</head>
<body>
<div class="homeContent">
  <h2>All Events and Attendees</h2>
  <?php
  $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
  if (!$con) {
      die('Could not connect: ' . mysqli_connect_error());
  }
  mysqli_select_db($con, 'library');

  $query = "SELECT events.EventID, events.EventName, events.Date, TIME_FORMAT(events.StartTime, '%h:%i %p') AS StartTime, TIME_FORMAT(events.EndTime, '%h:%i %p') AS EndTime, events.Location, events.Categories, events.Type, events.MaxAttendees, IFNULL(COUNT(event_attendees.StudentID), 0) AS Attendees, events.Status, events.CreatedDate, events.UpdatedDate FROM events LEFT JOIN event_attendees ON events.EventID = event_attendees.EventID GROUP BY events.EventID";
  $result = mysqli_query($con, $query);

  if(mysqli_num_rows($result) > 0) {
      echo "<table class='resultsTable'>";
      echo "<tr><th>Event ID</th><th>Event Name</th><th>Date</th><th>Start Time</th><th>End Time</th><th>Location</th><th>Categories</th><th>Type</th><th>Max Attendees</th><th>Attendees</th><th>Status</th><th>Created Date</th><th>Updated Date</th></tr>";
      while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td><a href='admin_view_event_attendees.php?event_id={$row['EventID']}'>{$row['EventID']}</a></td>";
          echo "<td><a href='details_event.php?event_id={$row['EventID']}'>{$row['EventName']}</a></td>";
          echo "<td>{$row['Date']}</td>";
          echo "<td>{$row['StartTime']}</td>";
          echo "<td>{$row['EndTime']}</td>";
          echo "<td>{$row['Location']}</td>";
          echo "<td>{$row['Categories']}</td>";
          echo "<td>{$row['Type']}</td>";
          echo "<td>{$row['MaxAttendees']}</td>";
          echo "<td>{$row['Attendees']}</td>";
          echo "<td>{$row['Status']}</td>";
          echo "<td>{$row['CreatedDate']}</td>";
          echo "<td>{$row['UpdatedDate']}</td>";
          echo "</tr>";
      }
      echo "</table>";
  } else {
      echo "<p>No events found.</p>";
  }

  mysqli_close($con);
  ?>
  <p><a href="admin_home.php">Back</a></p>
</div>
</body>
</html>
