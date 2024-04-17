<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Standard font */
            background-color: #f4f4f4; /* Light grey background */
            margin: 0;
            padding: 0;
        }

        .container {
            margin-left: 1rem;
            margin-right: 1rem;
            margin-top: 5rem;
        }

        h2 {
            color: #333;
        }

        .resultsTable {
            width: 100%; /* Full width */
            border-collapse: collapse; /* Collapse borders to avoid double borders */
            margin-top: 20px; /* Space above the table */
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid #ddd; /* Lighter border for a more subtle look */
            padding: 8px; /* Padding for table cells */
            text-align: left; /* Left align text in cells */
        }

        .resultsTable th {
            background-color: #f9f9f9; /* Very light gray background for headers */
            text-transform: uppercase; /* Capitalize header texts */
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none; /* No border */
            padding: 10px 20px; /* Padding inside the button */
            text-align: center; /* Centered text */
            text-decoration: none; /* No underline */
            display: inline-block; /* Fit to content width */
            font-size: 16px; /* Larger font size */
            margin: 4px 2px; /* Margin around buttons */
            cursor: pointer; /* Pointer cursor on hover */
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>View Students</h2>

        <!-- Filter Form -->
        <form method="get">
            <label for="filterBy">Filter By:</label>
            <select name="filterBy" id="filterBy">
                <option value="Status">Status</option>
                <option value="StudentID">StudentID</option>
                <option value="FirstName">First Name</option>
                <option value="Gender">Gender</option>
                <option value="GradeYearLevel">Grade Year Level</option>
            </select>
            <input type="text" name="filterValue" placeholder="Filter Value">
            <button type="submit">Apply Filter</button>
        </form>

        <?php
    // Database connection
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // Prepare SQL query
    $sql = "SELECT * FROM students";
    
    // Check if filter is provided
    if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
        $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
        $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
        $sql .= " WHERE $filterBy = '$filterValue'";
    }

    // Execute SQL query
    $result = mysqli_query($con, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Output table header
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

            // Output table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='admin_view_student_report.php?student_id={$row['StudentID']}'>" . $row['StudentID'] . "</a></td>";
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

            // Add buttons
            echo "<button onclick=\"location.href='add_student.php'\">Add Student</button>";
            echo "<button onclick=\"location.href='update_student.php'\">Update Student</button>";
            echo "<button onclick=\"location.href='delete_student.php'\">Delete Student</button>";
        } else {
            echo "No students found.";
        }
    } else {
        echo "Error executing SQL query: " . mysqli_error($con);
    }

    // Close connection
    mysqli_close($con);
?>
    <p><a href="admin_home.php">Back</a></p>
    </div>
</body>
</html>
