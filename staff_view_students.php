<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f4f4;
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .resultsTable th {
            background-color: #f9f9f9;
            text-transform: uppercase;
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Students</h2>

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
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM students";
    
    if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
        $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
        $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
        $sql .= " WHERE $filterBy = '$filterValue'";
    }

    $result = mysqli_query($con, $sql);

    if ($result) {
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

            echo "<button onclick=\"location.href='add_student.php'\">Add Student</button>";
            echo "<button onclick=\"location.href='update_student.php'\">Update Student</button>";
            echo "<button onclick=\"location.href='delete_student.php'\">Delete Student</button>";
        } else {
            echo "No students found.";
        }
    } else {
        echo "Error executing SQL query: " . mysqli_error($con);
    }

    mysqli_close($con);
?>
    <p><a href="staff_home.php">Back</a></p>
    </div>
</body>
</html>
