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
    <title>View Unpaid Fines</title>
    <style>
        .resultsTable {
            border-collapse: collapse;
            width: 100%;
        }
        
        .resultsTable th, .resultsTable td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        
        .resultsTable th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="margin-left:10rem; margin-top:5rem;">View Unpaid Fines</h2> 

    <?php
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM fines WHERE Status = 'Unpaid'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='resultsTable'>
                    <tr>
                        <th>Fine ID</th>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Fine Amount</th>
                        <th>Fine Date</th>
                        <th>Status</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['FineID'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['ItemID'] . "</td>";
                echo "<td>" . $row['ItemType'] . "</td>";
                echo "<td>" . $row['FineAmount'] . "</td>";
                echo "<td>" . $row['FineDate'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No unpaid fines found";
        }

        mysqli_close($con);
    ?>
</body>
</html>
