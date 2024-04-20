<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
    <link rel="stylesheet" href="data_form.css">
</head>
<body>

    <h2 id="header">Update Staff</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Staff ID: <input type="number" name="StaffID" required><br>
        <input type="submit" value="Check Staff ID">
    </form>

    <?php
    if(isset($message)) {
        echo "<div id='messageContainer'><p id='message'>$message</p></div>";
        echo "<script>setTimeout(function() { document.getElementById('messageContainer').style.display = 'none'; }, 1000);</script>";
    }
    ?>

    <?php
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
        echo "Password: <input type='password' name='Password' value='' placeholder='$passwordPlaceholder'><br>";
        echo "isAdmin: <input type='checkbox' name='isAdmin' value='1' " . ($isAdminPlaceholder == 1 ? "checked" : "") . "><br>";
        echo "isDeleted: <input type='checkbox' name='isDeleted' value='1' " . ($isDeletedPlaceholder == 1 ? "checked" : "") . "><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    }
    ?>

</body>
</html>
