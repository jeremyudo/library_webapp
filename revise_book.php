<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$ISBN = mysqli_real_escape_string($con, $_POST['ISBN']);
$newStock = '';
$sql = "UPDATE books SET ";

if (!empty($_POST['Title'])) {
    $sql .= "Title='" . $_POST['Title'] . "', ";
}
if (!empty($_POST['Author'])) {
    $sql .= "Author='" . $_POST['Author'] . "', ";
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
if (!empty($_POST['Stock'])) {
    $sql .= "Stock='" . $_POST['Stock'] . "', ";
    $newStock = $_POST['Stock'];
}
if (!empty($_POST['PageCount'])) {
    $sql .= "PageCount='" . $_POST['PageCount'] . "', ";
}
if (!empty($_POST['Format'])) {
    $sql .= "Format='" . $_POST['Format'] . "', ";
}

if ($newStock !== '') {
    $sql .= "Available='" . $newStock . "', ";
}

$sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "' ";
$sql = rtrim($sql, ", ");
$sql .= " WHERE ISBN='$ISBN'";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "Record updated successfully";

mysqli_close($con);
?>
