<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');

$startDate = $endDate = $studentOrFaculty = $TypeOfFine = "";
$fines = array();
$totalFines = 0;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $studentOrFaculty = isset($_POST['studentOrFaculty']) ? $_POST['studentOrFaculty'] : "";
    $TypeOfFine = isset($_POST['TypeOfFine']) ? $_POST['TypeOfFine'] : "";

    if (empty($startDate) || empty($endDate)) {
        $error = "Please enter both start and end dates.";
    } else {
        $sql = "SELECT FineID, UserID, StudentOrFaculty, TypeOfFine, FineAmount, PaymentDate 
                FROM fines 
                WHERE PaymentDate BETWEEN ? AND ?
                AND (? = '' OR StudentOrFaculty = ?)
                AND (? = '' OR TypeOfFine = ?)";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("ssssss", $startDate, $endDate, $studentOrFaculty, $studentOrFaculty, $TypeOfFine, $TypeOfFine);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $fines = $result->fetch_all(MYSQLI_ASSOC);
                    foreach ($fines as $fine) {
                        $totalFines += $fine['FineAmount'];
                    }
                } else {
                    $error = "No fines matching your query were found.";
                }
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fines Paid Report</title>
</head>
<body>
    <h2>Fines Paid Report</h2>
    <?php 
    if (!empty($error)) {
        echo '<div style="color: red;">' . $error . '</div>';
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Start Date: <input type="date" name="startDate" value="<?php echo $startDate; ?>">
        End Date: <input type="date" name="endDate" value="<?php echo $endDate; ?>">
        Student or Faculty:
        <select name="studentOrFaculty">
            <option value="">All</option>
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
        </select>
        Fine Type:
        <select name="TypeOfFine">
            <option value="">All</option>
            <option value="Late">Late</option>
            <option value="Damage">Damage</option>
            <option value="Loss">Loss</option>
        </select>
        <input type="submit" value="Generate Report">
    </form>
    
    <?php if(count($fines) > 0): ?>
        <h3>Total Fines Paid: $<?php echo number_format($totalFines, 2); ?></h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Fine ID</th>
                    <th>User ID</th>
                    <th>Student or Faculty</th>
                    <th>Fine Type</th>
                    <th>Fine Amount ($)</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fines as $fine): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fine['FineID']); ?></td>
                        <td><?php echo htmlspecialchars($fine['UserID']); ?></td>
                        <td><?php echo htmlspecialchars($fine['StudentOrFaculty']); ?></td>
                        <td><?php echo htmlspecialchars($fine['TypeOfFine']); ?></td>
                        <td><?php echo htmlspecialchars($fine['FineAmount']); ?></td>
                        <td><?php echo htmlspecialchars($fine['PaymentDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No fines found.</p>
    <?php endif; ?>
</body>
</html>
