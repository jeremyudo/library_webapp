<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');

$sql = "
    SELECT 
        h.HoldID,
        COALESCE(s.FirstName, f.FirstName) AS FirstName,
        COALESCE(s.LastName, f.LastName) AS LastName,
        CASE 
            WHEN s.StudentID IS NOT NULL THEN 'Student' 
            WHEN f.FacultyID IS NOT NULL THEN 'Faculty'
        END AS UserType,
        h.ExpirationDate,
        h.Status,
        d.MediaName AS ItemName
    FROM holds AS h
    LEFT JOIN students AS s ON h.UserID = s.StudentID
    LEFT JOIN faculty AS f ON h.UserID = f.FacultyID
    INNER JOIN digitalmediaitem AS d ON h.ItemID = d.DigiID
    ORDER BY h.HoldID
";

$result = mysqli_query($con, $sql);

$holds = [];
if ($result && mysqli_num_rows($result) > 0) {
    $holds = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "No holds found";
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holds Report - Digital Media</title>
</head>
<body>
    <h2>Holds Report - Digital Media</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Hold ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Type</th>
                <th>Expiration Date</th>
                <th>Status</th>
                <th>Item Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($holds) > 0): ?>
                <?php foreach ($holds as $hold): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hold['HoldID']); ?></td>
                        <td><?php echo htmlspecialchars($hold['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($hold['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($hold['UserType']); ?></td>
                        <td><?php echo htmlspecialchars($hold['ExpirationDate']); ?></td>
                        <td><?php echo htmlspecialchars($hold['Status']); ?></td>
                        <td><?php echo htmlspecialchars($hold['ItemName']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No holds found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
