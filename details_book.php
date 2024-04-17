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
<style>
    body {
    font-family: 'Courier New', Courier, monospace;
    background-color: #f5f5f5; /* Background color for the whole page */
    margin: 0;
    padding: 0;
}

.homeContent {
    max-width: 800px; /* Set the maximum width of the content area */
    margin: 20px auto; /* Center the content horizontally */
    padding: 20px;
    background-color: #fff; /* Background color for the content area */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow effect */
}

h2 {
    color: #333; /* Color for the heading */
}

.bookDetails {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px; /* Add some space below the table */
}

.bookDetails td {
    padding: 10px;
    border-bottom: 1px solid #ccc; /* Add a bottom border to separate rows */
}

.bookDetails td:first-child {
    font-weight: bold; /* Make the first column bold */
}

button:hover {
    background-color: #45a049; /* Darker background color on hover */
}

a {
    color: #007bff; /* Link color */
    text-decoration: none;
}

a:hover {
    text-decoration: underline; /* Underline links on hover */
}
button {
    padding: 10px 20px;
    background-color: #4caf50; /* Button background color */
    color: #fff; /* Button text color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px; /* Add right margin to create space between buttons */
}

/* Apply margin only to buttons inside the forms */
form button {
    font-family: 'Courier New', Courier, monospace;
    margin-right: 10px;
    margin-top: 5px;
}

/* Adjust margin for the last button in the form to avoid unnecessary space */
form button:last-child {
    margin-right: 0; /* Remove margin from the last button */
}
</style>
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
          
          // Add a form for checking in or checking out the book
          echo "<form method='post'>";
          echo "<input type='hidden' name='isbn' value='{$row['ISBN']}'>";
          
          // Check if the book is checked out by the student
          $queryCheckOut = "SELECT * FROM checkouts WHERE ItemID = '$isbn' AND UserID = '{$_SESSION['StudentID']}' AND CheckinDate IS NULL";
          $resultCheckOut = mysqli_query($con, $queryCheckOut);
          
          if(mysqli_num_rows($resultCheckOut) > 0) {
              // If the book is checked out by the student, show the check-in button
              echo "<button formaction='checkin_book.php' type='submit' name='operation' value='check-in'>Check In</button>";
          } else {
              // If the book is not checked out by the student, show the check-out button
              echo "<button formaction='checkout_book.php' type='submit' name='operation' value='check-out'>Check Out</button>";
          }
          
          echo "</form>";
          
          // Add a form for putting the book on hold
          if ($row['Available'] == 0) {
              echo "<form action='hold_book.php' method='post'>";
              echo "<input type='hidden' name='isbn' value='{$row['ISBN']}'>";
              echo "<button type='submit' name='operation' value='hold'>Hold</button>";
              echo "</form>";
          }
          
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