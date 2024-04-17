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
    <title>View Staff</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Set the font for the entire page */
        }

        /* CSS for table styles */
        .resultsTable {
            border-collapse: collapse; /* Collapse borders to avoid double borders */
            width: 100%; /* Full width */
            margin-top: 20px; /* Add some top margin to the table */
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid black; /* Add black borders to cells */
            padding: 8px; /* Add some padding for better spacing */
            text-align: left; /* Align text to the left */
        }

        .resultsTable th {
            background-color: #f2f2f2; /* Light gray background color for header cells */
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            margin-left: 1rem; /* Uniform left margin for buttons */
            margin-top: 1rem; /* Top margin for spacing between elements */
            padding: 10px 20px; /* Padding for a better button size */
            background-color: #4CAF50; /* Green background color */
            color: white; /* White text color */
            border: none; /* No borders */
            cursor: pointer; /* Pointer cursor on hover */
        }

        button:hover {
            background-color: #45a049; /* Slightly darker green background on hover */
        }
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Staff</h2> 

    <?php
        // Database connection
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        // SQL query to retrieve active staff members
        $sql = "SELECT * FROM staff WHERE Status = 'Active'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Start table
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Position</th>
                        <th>Date Hired</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                    </tr>";

            // Fetch and display each row of staff information
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['StaffID'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['Gender'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>" . $row['ContactNumber'] . "</td>";
                echo "<td>" . $row['EmailAddress'] . "</td>";
                echo "<td>" . $row['Position'] . "</td>";
                echo "<td>" . $row['DateHired'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['CreatedDate'] . "</td>";
                echo "<td>" . $row['UpdatedDate'] . "</td>";
                echo "</tr>";
            }

            // End table
            echo "</table>";
            echo "<button onclick=\"location.href='add_staff.php'\">Add Staff</button>";
            echo "<button onclick=\"location.href='update_staff.php'\">Update Staff</button>";
            echo "<button onclick=\"location.href='delete_staff.php'\">Delete Staff</button>";
        } else {
            echo "No active staff members found.";
        }

        // Close connection
        mysqli_close($con);
    ?>
</body>
</html>
