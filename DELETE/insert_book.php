<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Set NumberAvailable to the same value as Stock and NumberCheckedOut and NumberHeld to 0
$_POST['NumberAvailable'] = $_POST['Stock'];
$_POST['NumberCheckedOut'] = 0;
$_POST['NumberHeld'] = 0;

// SQL command that inserts into the books table
$sql = "INSERT INTO books (ISBN, Title, Authors, Publisher, PublicationDate, Genre, Description, Language, PageCount, CoverImageURL, Stock, NumberAvailable, NumberCheckedOut, NumberHeld, Cost) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the SQL statement
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    die('Error: ' . mysqli_error($con));
}

// Bind parameters with the values from the POST array
mysqli_stmt_bind_param($stmt, 'isssisssisiiidd', $_POST['ISBN'], $_POST['Title'], $_POST['Authors'], $_POST['Publisher'], $_POST['PublicationDate'], $_POST['Genre'], $_POST['Description'], $_POST['Language'], $_POST['PageCount'], $_POST['CoverImageURL'], $_POST['Stock'], $_POST['NumberAvailable'], $_POST['NumberCheckedOut'], $_POST['NumberHeld'], $_POST['Cost']);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die('Error: ' . mysqli_stmt_error($stmt));
}

echo "1 book record added";

// Close the statement
mysqli_stmt_close($stmt);

mysqli_close($con);

// Redirect to add_book.php after 1 second
header("refresh:1;url=add_book.php");
?>
