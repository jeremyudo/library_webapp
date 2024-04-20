<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$staffID = mysqli_real_escape_string($con, $_POST['StaffID']);

$update_staff_sql = "UPDATE staff SET Status = 'Inactive' WHERE StaffID='$staffID'";
if (!mysqli_query($con, $update_staff_sql)) {
    die('Error marking staff as inactive: ' . mysqli_error($con));
}

echo "Staff marked as inactive successfully";

mysqli_close($con);
?>
