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
<title>View Checkouts</title>
<link rel="stylesheet" href="styles/MainPage.css">
<link rel="stylesheet" href="styles/table.css"> <!-- Add the table.css file -->
</head>
<body>
<div class="homeContent">
  <h2>Books Currently Checked Out</h2>
  <?php
  // Perform database query to retrieve checkout records for the current user
  $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
  if (!$con) {
      die('Could not connect: ' . mysqli_connect_error());
  }
  mysqli_select_db($con, 'library');

  // Get the current user's StudentID
  $studentId = $_SESSION['StudentID'];

  // Query to retrieve checkout records for the current user where CheckinDate is NULL
  $query = "SELECT checkouts.ISBN, checkouts.CheckoutDate, checkouts.ReturnDate, books.Title, books.Author, books.Format FROM checkouts INNER JOIN books ON checkouts.ISBN = books.ISBN WHERE StudentID = '$studentId' AND CheckinDate IS NULL";
  $result = mysqli_query($con, $query);

  if(mysqli_num_rows($result) > 0) {
      // Display checkout records in a table with the resultsTable class
      echo "<table class='resultsTable'>";
      echo "<tr><th>Title</th><th>Author</th><th>ISBN</th><th>Format</th><th>Checkout Date</th><th>Due Date</th></tr>";
      while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td><a href='details_item.php?isbn={$row['ISBN']}'>{$row['Title']}</a></td>";
          echo "<td>{$row['Author']}</td>";
          echo "<td>{$row['ISBN']}</td>";
          echo "<td>{$row['Format']}</td>";
          echo "<td>{$row['CheckoutDate']}</td>";
          echo "<td>{$row['ReturnDate']}</td>";
          echo "</tr>";
      }
      echo "</table>";
  } else {
      echo "<p>No books currently checked out.</p>";
  }

  mysqli_close($con);
  ?>
  <!-- Add a link back to the home page -->
  <p><a href="home.php">Back to Home</a></p>
</div>
</body>
</html>
