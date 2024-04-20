<?php
include 'navbar.php';
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

if (isset($_GET['fine_id'])) {
    $fineID = $_GET['fine_id'];
    
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
    <link rel="stylesheet" href="view_holds.css">
    <script>
    function formatCreditCardNumber(input) {
        var value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1-');
        input.value = value;
    }
    
    function removeDashes(input) {
        input.value = input.value.replace(/-/g, '');
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

        <form action="process_payment.php?fine_id=<?php echo $fineID; ?>" method="post" onsubmit="removeDashes(this.elements['credit_card_number']);">
            <label for="credit_card_number">Credit Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number" pattern="\d{4}-\d{4}-\d{4}-\d{4}" placeholder="XXXX-XXXX-XXXX-XXXX" onchange="formatCreditCardNumber(this)" required><br><br>

            <label for="cvv">CVV:</label>
            <input type="number" id="cvv" name="cvv" maxlength="3" value="<?php echo isset($_POST['cvv']) ? $_POST['cvv'] : ''; ?>" placeholder="XXX" required><br><br>

            <label for="exp_date">Expiration Date:</label>
            <input type="date" id="exp_date" name="exp_date" required><br><br>

            <button type="submit">Pay Fine</button>
        </form>

        <p><a href="view_fines.php">Back to View Fines</a></p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
