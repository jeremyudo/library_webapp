<?php
include 'navbar_admin.php';
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Include database configuration file
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');

// Define variables and initialize with empty values
$startDate = $endDate = $userType = $gender = "";
$users = array();
$error = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  // Check if userType is set in POST request
  $userType = isset($_POST['userType']) ? $_POST['userType'] : "";
  // Correct variable name to lowercase and check if it's set
  $gender = isset($_POST['gender']) ? $_POST['gender'] : "";

  if (empty($startDate) || empty($endDate)) {
      $error = "Please enter both start and end dates.";
  } else {
      // Prepare a UNION ALL select statement to combine results from students and staff tables
      $sql = "(
                  SELECT StudentID AS id, FirstName, EmailAddress, CreatedDate, 'Student' AS type, Gender 
                  FROM students 
                  WHERE CreatedDate BETWEEN ? AND ? AND (? = '' OR ? = 'Student') AND (? = '' OR Gender = ?)
              ) UNION ALL (
                  SELECT StaffID AS id, FirstName, EmailAddress, CreatedDate, 'Staff' AS type, Gender 
                  FROM staff 
                  WHERE CreatedDate BETWEEN ? AND ? AND (? = '' OR ? = 'Staff') AND (? = '' OR Gender = ?)
              ) ORDER BY CreatedDate";

      if ($stmt = $con->prepare($sql)) {
          // Bind variables to the prepared statement as parameters
          $stmt->bind_param("ssssssssssss", $param_startDate, $param_endDate, $param_userType, $param_userType, $param_gender, $gender, $param_startDate, $param_endDate, $param_userType, $param_userType, $param_gender, $gender);

          // Set parameters
          $param_startDate = $startDate;
          $param_endDate = $endDate;
          $param_userType = $userType;
          $param_gender = $gender;

          // Attempt to execute the prepared statement
          if ($stmt->execute()) {
              // Store result
              $result = $stmt->get_result();

              // Check if there are any rows in the result
              if ($result->num_rows > 0) {
                  // Fetch result rows as an associative array
                  $users = $result->fetch_all(MYSQLI_ASSOC);
              } else {
                  $error = "No records matching your query were found.";
              }
          } else {
              $error = "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          $stmt->close();
      }
  }

  // Close connection
  $con->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Data Report</title>
    <style>
    body {
      font-family: 'Courier New', Courier, monospace;
        background-color: #f4f4f9;
        margin: 20px;
        padding: 0;
    }

    h2 {
        color: #333;
    }

    form {
      font-family: 'Courier New', Courier, monospace;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    input[type="date"], select {
      font-family: 'Courier New', Courier, monospace;
        width: 200px;
        padding: 8px;
        margin: 10px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
      font-family: 'Courier New', Courier, monospace;
        width: 200px;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
      font-family: 'Courier New', Courier, monospace;
        background-color: #45a049;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .error {
        color: red;
        font-size: 0.9em;
        margin: 10px 0;
    }
</style>

</head>
<body>
    <h2>New User Data Report</h2>
    <?php 
    if (!empty($error)) {
        echo '<div style="color: red;">' . $error . '</div>';
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Start Date: <input type="date" name="startDate" value="<?php echo $startDate; ?>">
        End Date: <input type="date" name="endDate" value="<?php echo $endDate; ?>">
        User Type:
        <select name="userType">
            <option value="">All</option>
            <option value="Student">Student</option>
            <option value="Staff">Staff</option>
        </select>
        Gender:
        <select name="gender">
            <option value="">All</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <input type="submit" value="Generate Report">
    </form>
    
    <?php if(count($users) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date Registered</th>
                    <th>Type</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($user['EmailAddress']); ?></td>
                        <td><?php echo htmlspecialchars($user['CreatedDate']); ?></td>
                        <td><?php echo htmlspecialchars($user['type']); ?></td>
                        <td><?php echo htmlspecialchars($user['Gender']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
