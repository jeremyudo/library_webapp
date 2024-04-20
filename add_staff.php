<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link rel="stylesheet" href="data_form.css">
    <style>
        #header {
            text-align: center;
        }

        /* Additional styling for the PageCount field */
        textarea[name="Description"] {
            height: 100px; /* Adjust the height as needed */
        }

        /* Style for required fields */
        .required::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }

        /* Style for buttons */
        .button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Add new staff member and modify the staff information -->
<form action="" method="post">
    <h2 id="header">Add Staff</h2>
    Staff ID: <input type="number" name="StaffID" required /><br>
    First Name: <input type="text" name="FirstName" required /><br>
    Last Name: <input type="text" name="LastName" required /><br>
    Date of Birth: <input type="date" name="DateOfBirth" required /><br>
    Gender:
    <select name="Gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br>
    Address: <input type="text" name="Address" /><br>
    Contact Number: <input type="text" name="ContactNumber" /><br>
    Email Address: <input type="text" name="EmailAddress" /><br>
    Position: 
    <select name="Position" required>
        <option value="">Select Position</option>
        <option value="Librarian">Librarian</option>
        <option value="IT Specialist">IT Specialist</option>
        <option value="Clerk">Clerk</option>
        <option value="Security">Security</option>
        <option value="Admin">Admin</option>
    </select><br>
    Date Hired: <input type="date" name="DateHired" required /><br>
    Status: 
    <select name="Status" required>
        <option value="">Select Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select><br>
    Password: <input type="text" name="Password" required /><br>
    <input type="submit" name="submit" value="Add Staff" class="button">
    <a href="admin_view_staff.php" class="button">Back</a>
</form>

<?php
// Database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Set default timezone to prevent date-related issues
    date_default_timezone_set('UTC');

    // Get current date and time
    $createdDate = date('Y-m-d H:i:s');
    $updatedDate = date('Y-m-d H:i:s');

    // Prepare the SQL statement
    $stmt = mysqli_prepare($con, "INSERT INTO staff (StaffID, FirstName, LastName, DateOfBirth, Gender, Address, ContactNumber, EmailAddress, Position, DateHired, Status, CreatedDate, UpdatedDate, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Error: ' . mysqli_error($con));
    }

    // Bind parameters with the values from the POST array
    mysqli_stmt_bind_param($stmt, 'isssssssssssss', $_POST['StaffID'], $_POST['FirstName'], $_POST['LastName'], $_POST['DateOfBirth'], $_POST['Gender'], $_POST['Address'], $_POST['ContactNumber'], $_POST['EmailAddress'], $_POST['Position'], $_POST['DateHired'], $_POST['Status'], $createdDate, $updatedDate, $_POST['Password']);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        die('Error: ' . mysqli_stmt_error($stmt));
    }

    echo "1 record added";
    header("Location: admin_view_staff.php"); // GOES BACK TO ORIGINAL PAGE 

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);
?>

</body>
</html>
