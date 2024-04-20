<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

$studentID = mysqli_real_escape_string($con, $_POST['StudentID']);

$update_student_sql = "UPDATE students SET Status = 'Unenrolled' WHERE StudentID='$studentID'";
if (!mysqli_query($con, $update_student_sql)) {
    die('Error updating student: ' . mysqli_error($con));
}

echo "Student record updated successfully";

mysqli_close($con);
?>
