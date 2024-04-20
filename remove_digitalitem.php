<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

$DigitalID = mysqli_real_escape_string($con, $_POST['DigitalID']);

$update_digital_item_sql = "UPDATE digitalitems SET isDeleted = true WHERE DigitalID = '$DigitalID'";
if (!mysqli_query($con, $update_digital_item_sql)) {
    die('Error updating digital item: ' . mysqli_error($con));
}

echo "Digital item marked as deleted successfully";

mysqli_close($con);
?>
