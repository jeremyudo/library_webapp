<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$sql = "INSERT INTO library_staff (StaffID, FirstName, LastName, DateOfBirth, Gender, Address, ContactNumber, EmailAddress, Position, Department, JoiningDate, Salary, Status, CreatedDate, UpdatedDate, Password, IsAdmin) VALUES ('" . $_POST['StaffID'] . "','" . $_POST['FirstName'] . "','" . $_POST['LastName'] . "', '" . $_POST['DateOfBirth'] . "', '" . $_POST['Gender'] . "', '" . $_POST['Address'] . "', '" . $_POST['ContactNumber'] . "', '" . $_POST['EmailAddress'] . "', '" . $_POST['Position'] . "', '" . $_POST['Department'] . "', '" . $_POST['JoiningDate'] . "', '" . $_POST['Salary'] . "', '" . $_POST['Status'] . "', '" . $_POST['CreatedDate'] . "', '" . $_POST['UpdatedDate'] . "', '" . $_POST['Password'] . "', '" . $_POST['IsAdmin'] . "')";

if (!mysqli_query($con, $sql)) {
  die('Error: ' . mysqli_error($con));
}
echo "1 record added";

mysqli_close($con);