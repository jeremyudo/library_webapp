<?php
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
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
        }

        .resultsTable {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .resultsTable th, .resultsTable td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .resultsTable th {
            background-color: #f2f2f2;
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            margin-left: 1rem;
            margin-top: 1rem;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Staff</h2> 

    <form method="get">
        <label for="filterBy">Filter By:</label>
        <select name="filterBy" id="filterBy">
            <option value="Status">Status</option>
            <option value="StaffID">Staff ID</option>
            <option value="FirstName">First Name</option>
        </select>
        <input type="text" name="filterValue" placeholder="Filter Value">
        <button type="submit">Apply Filter</button>
    </form>

    <table class='resultsTable'>
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
            <th>Is Admin</th>
        </tr>

        <?php
            $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
            if (!$con) {
                die('Could not connect: ' . mysqli_connect_error());
            }

            $sql = "SELECT * FROM staff WHERE Status = 'Active'";
            
            if (isset($_GET['filterBy']) && isset($_GET['filterValue'])) {
                $filterBy = mysqli_real_escape_string($con, $_GET['filterBy']);
                $filterValue = mysqli_real_escape_string($con, $_GET['filterValue']);
                $sql .= " AND $filterBy = '$filterValue'";
            }

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
        ?>
                    <tr>
                        <td><?php echo $row['StaffID']; ?></td>
                        <td><?php echo $row['FirstName']; ?></td>
                        <td><?php echo $row['LastName']; ?></td>
                        <td><?php echo $row['DateOfBirth']; ?></td>
                        <td><?php echo $row['Gender']; ?></td>
                        <td><?php echo $row['Address']; ?></td>
                        <td><?php echo $row['ContactNumber']; ?></td>
                        <td><?php echo $row['EmailAddress']; ?></td>
                        <td><?php echo $row['Position']; ?></td>
                        <td><?php echo $row['DateHired']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['CreatedDate']; ?></td>
                        <td><?php echo $row['UpdatedDate']; ?></td>
                        <td><?php echo ($row['isAdmin'] ? 'Yes' : 'No'); ?></td>
                    </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='14'>No active staff members found.</td></tr>";
            }

            mysqli_close($con);
        ?>
    </table>

    <button onclick="location.href='add_staff.php'">Add Staff</button>
    <button onclick="location.href='update_staff.php'">Update Staff</button>
    <button onclick="location.href='delete_staff.php'">Delete Staff</button>

    <p><a href="admin_home.php">Back</a></p>
</body>
</html>
