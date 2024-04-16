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
<title>Book Details</title>
<link rel="stylesheet" href="styles/MainPage.css">
</head>
<body>
<div class="homeContent">
  <!-- Display book details here -->
  <?php
  // Check if ISBN is provided
  if(isset($_GET['isbn'])) {
      $isbn = $_GET['isbn'];
      // Perform database query to retrieve book details based on ISBN
      $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
      if (!$con) {
          die('Could not connect: ' . mysqli_connect_error());
      }
      mysqli_select_db($con, 'library');
      
      $query = "SELECT * FROM books WHERE ISBN = '$isbn'";
      $result = mysqli_query($con, $query);
      if(mysqli_num_rows($result) > 0) {
          // Display book details
          $row = mysqli_fetch_assoc($result);
          echo "<h2>Book Details</h2>";
          echo "<table class='bookDetails'>";
          echo "<tr><td>Title:</td><td><a href='details_item.php?isbn={$row['ISBN']}'>{$row['Title']}</a></td></tr>";
          echo "<tr><td>Author:</td><td>{$row['Author']}</td></tr>";
          echo "<tr><td>ISBN:</td><td>{$row['ISBN']}</td></tr>";
          echo "<tr><td>Description:</td><td>{$row['Description']}</td></tr>";
          echo "<tr><td>Language:</td><td>{$row['Language']}</td></tr>";
          echo "<tr><td>Available Copies:</td><td>{$row['Available']}</td></tr>";
          echo "<tr><td>Page Count:</td><td>{$row['PageCount']}</td></tr>";
          echo "<tr><td>Genre:</td><td>{$row['Genre']}</td></tr>";
          echo "</table>";
          
          // Add a form for checking out the book
          echo "<form action='checkout_book.php' method='post'>";
          echo "<input type='hidden' name='isbn' value='{$row['ISBN']}'>";
          echo "<button type='submit' name='operation' value='check-out'>Check Out</button>";
          echo "</form>";
          
          // Check if available count is less than stock count
          if ($row['Available'] < $row['Stock']) {
              // Add a form for checking in the book
              echo "<form action='checkin_book.php' method='post'>";
              echo "<input type='hidden' name='isbn' value='{$row['ISBN']}'>";
              echo "<button type='submit' name='operation' value='check-in'>Check In</button>";
              echo "</form>";
          } // No else condition needed here, as we don't want to display any message if available is equal to stock

          // Add a form for putting the book on hold
            echo "<form action='hold_book.php' method='post'>";
            echo "<input type='hidden' name='isbn' value='{$row['ISBN']}'>";
            echo "<button type='submit' name='operation' value='hold'>Hold</button>";
            echo "</form>";
      } else {
          echo "<p>No book details found for the provided ISBN.</p>";
      }
      mysqli_close($con);
  } else {
      echo "<p>No ISBN provided.</p>";
  }
  ?>
  <!-- Add a link back to the home page -->
  <p><a href="home.php">Back to Home</a></p>
</div>
</body>
</html>