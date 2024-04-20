<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$_POST['Available'] = $_POST['Stock'];
$_POST['Holds'] = 0;

$DigitalID = $_POST['DigitalID'];

$sql = "INSERT INTO digitalitems (DigitalID, Title, Author, Format, Publisher, PublicationYear, Genre, Description, Language, CoverImage, Stock, Available, Holds) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    die('Error: ' . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, 'isssisssssiii', $DigitalID, $_POST['Title'], $_POST['Author'], $_POST['Format'], $_POST['Publisher'], $_POST['PublicationYear'], $_POST['Genre'], $_POST['Description'], $_POST['Language'], $_POST['CoverImage'], $_POST['Stock'], $_POST['Available'], $_POST['Holds']);

if (!mysqli_stmt_execute($stmt)) {
    die('Error: ' . mysqli_stmt_error($stmt));
}

echo "1 digital item added";

mysqli_stmt_close($stmt);

mysqli_close($con);
