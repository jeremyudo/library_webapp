<?php
// Database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Get ISBN from POST
$ISBN = mysqli_real_escape_string($con, $_POST['ISBN']);

// Delete book from the database
$delete_book_sql = "DELETE FROM books WHERE ISBN='$ISBN'";
if (!mysqli_query($con, $delete_book_sql)) {
    die('Error deleting book: ' . mysqli_error($con));
}

// Confirm successful deletion
echo "Book removed successfully";
header("Location: staff_view_books.php");

// Close the database connection
mysqli_close($con);
?>