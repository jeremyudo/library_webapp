<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$facultyID = mysqli_real_escape_string($con, $_POST['FacultyID']);
$sql = "UPDATE faculty SET ";

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
if (!empty($_POST['Department'])) {
    $sql .= "Department='" . $_POST['Department'] . "', ";
}
if (!empty($_POST['Position'])) {
    $sql .= "Position='" . $_POST['Position'] . "', ";
}
if (!empty($_POST['DateHired'])) {
    $sql .= "DateHired='" . $_POST['DateHired'] . "', ";
}
if (!empty($_POST['Status'])) {
    $sql .= "Status='" . $_POST['Status'] . "', ";
}
if (!empty($_POST['Password'])) {
    $sql .= "Password='" . $_POST['Password'] . "', ";
}

$sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "' ";
$sql = rtrim($sql, ", ");
$sql .= " WHERE FacultyID='$facultyID'";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "Record updated successfully";

mysqli_close($con);
?>
