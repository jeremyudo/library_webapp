<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CSCE813 Project 2 - Adding new reader and modifying reader information addnewreader.php</title>
</head>
<body>

<!-- ADD new reader and modify the reader information -->
<form action="insert_staff.php" method="post">
Staff ID: <input type="text" name="StaffID" /><br>
First Name: <input type="text" name="FirstName" /><br>
Last Name: <input type="text" name="LastName" /><br>
Date of Birth: <input type="text" name="DateOfBirth" /><br>
Gender:
<select name="Gender">
  <option value="Male">Male</option>
  <option value="Female">Female</option>
  <option value="Other">Other</option>
</select><br>
Address: <input type="text" name="Address" /><br>
Contact Number: <input type="text" name="ContactNumber" /><br>
Email Address: <input type="text" name="EmailAddress" /><br>
Position: <input type="text" name="Position" /><br>
Department: <input type="text" name="Department" /><br>
Joining Date: <input type="text" name="JoiningDate" /><br>
Salary: <input type="text" name="Salary" /><br>
Status: 
<select name="Status">
  <option value="Active">Yes</option>
  <option value="In Active">No</option>
</select><br>
CreatedDate: <input type="text" name="CreatedDate" /><br>
Updated Date: <input type="text" name="UpdatedDate" /><br>
Password: <input type="text" name="Password" /><br>
IsAdmin: 
<select name="IsAdmin">
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select><br>
<input type="submit" />
</form>

<p><b><big>Want to modify one patron information? Please click this <a href="view.php">link</a>!</big></b></p>

</body>
</html>
