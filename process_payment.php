<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

// Perform database connection
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize credit card number, CVV, and expiration date
    $credit_card_number = sanitize_input($_POST['credit_card_number']);
    $cvv = sanitize_input($_POST['cvv']);
    $exp_date = sanitize_input($_POST['exp_date']);

    // Retrieve Fine ID from the URL
    if (isset($_GET['fine_id'])) {
        $fineID = $_GET['fine_id'];
        
        // Update status of the fine to Paid
        $query = "UPDATE fines SET Status = 'Paid' WHERE FineID = $fineID";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "Payment successful. Fine status updated to Paid.";
        } else {
            echo "Error updating fine status: " . mysqli_error($con);
        }
    } else {
        echo "Fine ID not provided.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
