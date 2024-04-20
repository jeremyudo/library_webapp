<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$studentID = mysqli_real_escape_string($con, $_POST['StudentID']);
$sql = "UPDATE students SET ";

if (!empty($_POST['FirstName'])) {
    $sql .= "FirstName='" . $_POST['FirstName'] . "', ";
}
if (!empty($_POST['LastName'])) {
    $sql .= "LastName='" . $_POST['LastName'] . "', ";
}
if (!empty($_POST['DateOfBirth'])) {
    $sql .= "DateOfBirth='" . $_POST['DateOfBirth'] . "', ";
}
if (!empty($_POST['Gender'])) {
    $sql .= "Gender='" . $_POST['Gender'] . "', ";
}
if (!empty($_POST['Address'])) {
    $sql .= "Address='" . $_POST['Address'] . "', ";
}
if (!empty($_POST['ContactNumber'])) {
    $sql .= "ContactNumber='" . $_POST['ContactNumber'] . "', ";
}
if (!empty($_POST['EmailAddress'])) {
    $sql .= "EmailAddress='" . $_POST['EmailAddress'] . "', ";
}
if (!empty($_POST['GradeYearLevel'])) {
    $sql .= "GradeYearLevel='" . $_POST['GradeYearLevel'] . "', ";
}
if (!empty($_POST['Status'])) {
    $sql .= "Status='" . $_POST['Status'] . "', ";
}
if (!empty($_POST['Password'])) {
    $sql .= "Password='" . $_POST['Password'] . "', ";
}

$sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "', ";
$sql = rtrim($sql, ", ");
$sql .= " WHERE StudentID='$studentID'";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "Record updated successfully";

mysqli_close($con);
?>
