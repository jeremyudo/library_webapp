<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$DigitalID = mysqli_real_escape_string($con, $_POST['DigitalID']);
$newStock = '';
$sql = "UPDATE digitalitems SET ";

if (!empty($_POST['Stock'])) {
    $sql .= "Stock='" . $_POST['Stock'] . "', ";
    $newStock = $_POST['Stock'];
}
if (!empty($_POST['Title'])) {
    $sql .= "Title='" . $_POST['Title'] . "', ";
}
if (!empty($_POST['Author'])) {
    $sql .= "Author='" . $_POST['Author'] . "', ";
}
if (!empty($_POST['Format'])) {
    $sql .= "Format='" . $_POST['Format'] . "', ";
}
if (!empty($_POST['Publisher'])) {
    $sql .= "Publisher='" . $_POST['Publisher'] . "', ";
}
if (!empty($_POST['PublicationYear'])) {
    $sql .= "PublicationYear='" . $_POST['PublicationYear'] . "', ";
}
if (!empty($_POST['Genre'])) {
    $sql .= "Genre='" . $_POST['Genre'] . "', ";
}
if (!empty($_POST['Description'])) {
    $sql .= "Description='" . $_POST['Description'] . "', ";
}
if (!empty($_POST['Language'])) {
    $sql .= "Language='" . $_POST['Language'] . "', ";
}
if (!empty($_POST['CoverImage'])) {
    $sql .= "CoverImage='" . $_POST['CoverImage'] . "', ";
}

if ($newStock !== '') {
    $sql .= "Available='" . $newStock . "', ";
}

$sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "' ";
$sql = rtrim($sql, ", ");
$sql .= " WHERE DigitalID='$DigitalID'";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "Record updated successfully";

mysqli_close($con);
?>
