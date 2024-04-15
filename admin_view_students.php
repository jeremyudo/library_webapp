<?php
    // Start session
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Redirect to admin login page if not logged in
        header("Location: admin_login.php");
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="admin_view_students.css">

</head>
<body>
    <div class="container">
        <h2>View Students</h2>
        <?php
            // Database connection
            $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
            if (!$con) {
                die('Could not connect: ' . mysqli_connect_error());
            }

            // SQL query to retrieve all students
            $sql = "SELECT * FROM students";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table class='resultsTable'>";
                echo "<tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Grade Year Level</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                      </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['StudentID'] . "</td>";
                    echo "<td>" . $row['FirstName'] . "</td>";
                    echo "<td>" . $row['LastName'] . "</td>";
                    echo "<td>" . $row['DateOfBirth'] . "</td>";
                    echo "<td>" . $row['Gender'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['ContactNumber'] . "</td>";
                    echo "<td>" . $row['EmailAddress'] . "</td>";
                    echo "<td>" . $row['GradeYearLevel'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['CreatedDate'] . "</td>";
                    echo "<td>" . $row['UpdatedDate'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }

            mysqli_close($con);
        ?>
        <button onclick="location.href='add_student.php'">Add Student</button>
        <button onclick="location.href='update_student.php'">Update Student</button>
        <button onclick="location.href='delete_student.php'">Delete Student</button>
    </div>
</body>
</html>
