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
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            font-size: 25px;
            color: #333;
            margin: 20px 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin: 20px;
        }

        .resultsTable {
            font-size: 13px;
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        .resultsTable th {
            background-color: #f9f9f9;
            color: #333;
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
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Staff</h2> 

        <?php
            // Database connection
            $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
            if (!$con) {
                die('Could not connect: ' . mysqli_connect_error());
            }

            // SQL query to retrieve all staff members
            $sql = "SELECT * FROM staff";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
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

                echo "</table>";
                echo "<button onclick=\"location.href='add_staff.php'\">Add Staff</button>";
                echo "<button onclick=\"location.href='update_staff.php'\">Update Staff</button>";
                echo "<button onclick=\"location.href='delete_staff.php'\">Delete Staff</button>";
            } else {
                echo "<p>No results found.</p>";
            }

            mysqli_close($con);
        ?>
    </div>
</body>
</html>
