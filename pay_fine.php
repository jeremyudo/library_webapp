<?php
include 'navbar.php';
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

// Check if Fine ID is provided in the URL
if (isset($_GET['fine_id'])) {
    $fineID = $_GET['fine_id'];
    
    // Query the fine details based on Fine ID
    $query = "SELECT * FROM fines WHERE FineID = $fineID";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Fine not found.";
        exit;
    }
} else {
    echo "Fine ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Fine</title>
    <link rel="stylesheet" href="view_holds.css"> <!-- Include your CSS file here -->
    <script>
    // Function to format credit card number input with dashes every four digits
    function formatCreditCardNumber(input) {
        // Remove any existing dashes and non-numeric characters
        var value = input.value.replace(/\D/g, '');
        // Add dash after every four digits
        value = value.replace(/(\d{4})(?=\d)/g, '$1-');
        // Update input value
        input.value = value;
    }
    
    // Function to remove dashes from credit card number input
    function removeDashes(input) {
        input.value = input.value.replace(/-/g, ''); // Remove all dashes
    }
    </script>
</head>
<body>
    <div class="homeContent">
        <h2 class="title_pay_fine">Fine Details</h2>

        <table class="fineDetails">
            <tr>
                <th>Fine ID:</th>
                <td><?php echo $row['FineID']; ?></td>
            </tr>
            <tr>
                <th>Item ID:</th>
                <td><?php echo $row['ItemID']; ?></td>
            </tr>
            <tr>
                <th>Item Type:</th>
                <td><?php echo $row['ItemType']; ?></td>
            </tr>
            <tr>
                <th>Fine Amount:</th>
                <td><?php echo $row['FineAmount']; ?></td>
            </tr>
            <tr>
                <th>Fine Date:</th>
                <td><?php echo $row['FineDate']; ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><?php echo $row['Status']; ?></td>
            </tr>
        </table>

        <!-- Credit Card Payment Form -->
        <form action="process_payment.php?fine_id=<?php echo $fineID; ?>" method="post" onsubmit="removeDashes(this.elements['credit_card_number']);"> <!-- Pass Fine ID in the URL -->
            <label for="credit_card_number">Credit Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number" pattern="\d{4}-\d{4}-\d{4}-\d{4}" placeholder="XXXX-XXXX-XXXX-XXXX" onchange="formatCreditCardNumber(this)" required><br><br>

            <label for="cvv">CVV:</label>
            <input type="number" id="cvv" name="cvv" maxlength="3" value="<?php echo isset($_POST['cvv']) ? $_POST['cvv'] : ''; ?>" placeholder="XXX" required><br><br>

            <label for="exp_date">Expiration Date:</label>
            <input type="date" id="exp_date" name="exp_date" required><br><br>

            <button type="submit">Pay Fine</button>
        </form>

        <!-- Add a link back to the previous page -->
        <p><a href="view_fines.php">Back to View Fines</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
