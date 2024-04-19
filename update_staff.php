<?php
include 'navbar.php';

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

// Function to sanitize user input
function sanitize_input($data) {
    if ($data === null) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables
$message = "";
$firstNamePlaceholder = "Enter First Name";
$lastNamePlaceholder = "Enter Last Name";

// Check if the form is submitted for StaffID checking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize StaffID from the form
    $staffID = isset($_POST['StaffID']) ? sanitize_input($_POST['StaffID']) : '';

    // Check if the StaffID exists in the database
    $query = "SELECT * FROM staff WHERE StaffID = '$staffID'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die('Error executing query: ' . mysqli_error($con));
    }

    // If StaffID exists, retrieve the first and last names and set them as placeholders
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $contactNumber = $row['ContactNumber'];
        $emailAddress = $row['EmailAddress'];
        $position = $row['Position'];
        $dateHired = $row['DateHired'];
        $status = $row['Status'];
        $dateOfBirth = $row['DateOfBirth'];
        $gender = $row['Gender'];
        $address = $row['Address'];
        $password = $row['Password'];
        $isAdmin = $row['isAdmin'];
        $isDeleted = $row['isDeleted'];
        $message = "Staff ID $staffID exists in the database.";
        $firstNamePlaceholder = $firstName;
        $lastNamePlaceholder = $lastName;
        $contactNumberPlaceholder = $contactNumber;
        $emailAddressPlaceholder = $emailAddress;
        $positionPlaceholder = $position;
        $dateHiredPlaceholder = $dateHired;
        $statusPlaceholder = $status;
        $dateOfBirthPlaceholder = $dateOfBirth;
        $genderPlaceholder = $gender;
        $addressPlaceholder = $address;
        $passwordPlaceholder = $password;
        $isAdminPlaceholder = $isAdmin;
        $isDeletedPlaceholder = $isDeleted;
    } else {
        $message = "Staff ID $staffID does not exist in the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
    <link rel="stylesheet" href="data_form.css">
</head>
<body>

    <h2 id="staffHeader">Update Staff</h2>


    <!-- Form to input StaffID -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Staff ID: <input type="number" name="StaffID" required><br>
        <input type="submit" value="Check Staff ID">
    </form>

    <?php
    // Display message about StaffID existence
    if(isset($message)) {
        echo "<div id='messageContainer'><p id='message'>$message</p></div>";
        echo "<script>setTimeout(function() { document.getElementById('messageContainer').style.display = 'none'; }, 1000);</script>";
    }


    

    // Show input fields for first name and last name if StaffID exists
    if(isset($firstName) && isset($lastName)) {
        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
        echo "<input type='hidden' name='StaffID' value='$staffID'>";
        echo "First Name: <input type='text' name='FirstName' value='' placeholder='$firstNamePlaceholder'><br>";
        echo "Last Name: <input type='text' name='LastName' value='' placeholder='$lastNamePlaceholder'><br>";
        echo "Date of Birth: <input type='date' name='DateOfBirth' value='' placeholder='$dateOfBirthPlaceholder'><br>";
        echo "Gender: <select name='Gender'>
                    <option value='Male' " . ($genderPlaceholder == 'Male' ? 'selected' : '') . ">Male</option>
                    <option value='Female' " . ($genderPlaceholder == 'Female' ? 'selected' : '') . ">Female</option>
                    <option value='Other' " . ($genderPlaceholder == 'Other' ? 'selected' : '') . ">Other</option>
                </select><br>";
        echo "Address: <input type='text' name='Address' value='' placeholder='$addressPlaceholder'><br>";
        echo "Contact Number: <input type='text' name='ContactNumber' value='' placeholder='$contactNumberPlaceholder'><br>";
        echo "Email Address: <input type='email' name='EmailAddress' value='' placeholder='$emailAddressPlaceholder'><br>";
        echo "Position: <select name='Position'>
                    <option value='Librarian' " . ($positionPlaceholder == 'Librarian' ? 'selected' : '') . ">Librarian</option>
                    <option value='IT Specialist' " . ($positionPlaceholder == 'IT Specialist' ? 'selected' : '') . ">IT Specialist</option>
                    <option value='Clerk' " . ($positionPlaceholder == 'Clerk' ? 'selected' : '') . ">Clerk</option>
                    <option value='Security' " . ($positionPlaceholder == 'Security' ? 'selected' : '') . ">Security</option>
                    <option value='Admin' " . ($positionPlaceholder == 'Admin' ? 'selected' : '') . ">Admin</option>
                </select><br>";
        echo "Date Hired: <input type='date' name='DateHired' value='' placeholder='$dateHiredPlaceholder'><br>";
        echo "Status: <select name='Status'>
                    <option value='Active' " . ($statusPlaceholder == 'Active' ? 'selected' : '') . ">Active</option>
                    <option value='Inactive' " . ($statusPlaceholder == 'Inactive' ? 'selected' : '') . ">Inactive</option>
                    <option value='On Leave' " . ($statusPlaceholder == 'On Leave' ? 'selected' : '') . ">On Leave</option>
                </select><br>";
        echo "Password: <input type='password' name='Password' value='' <br>";
        echo "isAdmin: <input type='checkbox' name='isAdmin' value='1' " . ($isAdminPlaceholder == 1 ? "checked" : "") . "><br>";
        echo "isDeleted: <input type='checkbox' name='isDeleted' value='1' " . ($isDeletedPlaceholder == 1 ? "checked" : "") . "><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    }
    ?>

</body>
</html>

<?php
// Check if the form is submitted for updating staff details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['FirstName']) && isset($_POST['LastName'])) {
    // Retrieve and sanitize inputs from the form
    $staffID = sanitize_input($_POST['StaffID']);
    $firstName = sanitize_input($_POST['FirstName']);
    $lastName = sanitize_input($_POST['LastName']);
    $dateOfBirth = sanitize_input($_POST['DateOfBirth']);
    $gender = sanitize_input($_POST['Gender']);
    $address = sanitize_input($_POST['Address']);
    $contactNumber = sanitize_input($_POST['ContactNumber']);
    $emailAddress = sanitize_input($_POST['EmailAddress']);
    $position = sanitize_input($_POST['Position']);
    $dateHired = sanitize_input($_POST['DateHired']);
    $status = sanitize_input($_POST['Status']);
    $password = sanitize_input($_POST['Password']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0; // Check if checkbox is checked
    $isDeleted = isset($_POST['isDeleted']) ? 1 : 0; // Check if checkbox is checked

    // Construct the update query
    $sql = "UPDATE staff SET ";

    // Check each field individually and append to the query if it's provided in the form
    if (!empty($firstName)) {
        $sql .= "FirstName='$firstName', ";
    }
    if (!empty($lastName)) {
        $sql .= "LastName='$lastName', ";
    }
    if (!empty($dateOfBirth)) {
        $sql .= "DateOfBirth='$dateOfBirth', ";
    }
    if (!empty($gender)) {
        $sql .= "Gender='$gender', ";
    }
    if (!empty($address)) {
        $sql .= "Address='$address', ";
    }
    if (!empty($contactNumber)) {
        $sql .= "ContactNumber='$contactNumber', ";
    }
    if (!empty($emailAddress)) {
        $sql .= "EmailAddress='$emailAddress', ";
    }
    if (!empty($position)) {
        $sql .= "Position='$position', ";
    }
    if (!empty($dateHired)) {
        $sql .= "DateHired='$dateHired', ";
    }
    if (!empty($status)) {
        $sql .= "Status='$status', ";
    }
    if (!empty($password)) {
        $sql .= "Password='$password', ";
    }
    $sql .= "isAdmin='$isAdmin', "; // Append isAdmin field
    $sql .= "isDeleted='$isDeleted', "; // Append isDeleted field

    // Append the UpdatedDate field with the current date and time
    $sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "' ";

    // Remove the trailing comma and space from the query string
    $sql = rtrim($sql, ", ");

    // Add the WHERE clause to specify which record to update
    $sql .= " WHERE StaffID='$staffID'";

    // Execute the update query
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }

    // Display success message for 2 seconds
    echo "<div id='success_message'>Updated successfully</div>";
    echo "<script>setTimeout(function() { document.getElementById('success_message').style.display = 'none'; }, 500);</script>";

    // Redirect to admin_view_staff.php after update
    header("refresh:2;url=admin_view_staff.php");
    exit();
}

mysqli_close($con);
?>
