<?php
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Item Details</title>
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .detailsContainer {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .detailsContainer p {
        font-size: 16px;
        margin-bottom: 8px;
    }

    .detailsContainer strong {
        font-weight: bold;
    }

    .detailsContainer form {
        font-family: 'Courier New', Courier, monospace;
        margin-top: 20px;
    }

    .detailsContainer input[type='submit'] {
        font-family: 'Courier New', Courier, monospace;
        padding: 10px 20px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }

    .detailsContainer input[type='submit']:last-child {
        margin-right: 0;
    }

    .detailsContainer a {
        color: #007bff;
        text-decoration: none;
    }

    .detailsContainer a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
<div class="detailsContainer">
    <?php
    if(isset($_GET['digitalid'])) {
        $digitalID = $_GET['digitalid'];
        
        $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }
        mysqli_select_db($con, 'library');
        
        $query = "SELECT Title, Author, DigitalID, PublicationYear, Description, Genre, Language, Format, Available FROM digitalitems WHERE DigitalID = '$digitalID'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<h2>Digital Item Details</h2>";
            echo "<p><strong>Title:</strong> {$row['Title']}</p>";
            echo "<p><strong>Author:</strong> {$row['Author']}</p>";
            echo "<p><strong>Digital ID:</strong> {$row['DigitalID']}</p>";
            echo "<p><strong>Publication Year:</strong> {$row['PublicationYear']}</p>";
            echo "<p><strong>Description:</strong> {$row['Description']}</p>";
            echo "<p><strong>Genre:</strong> {$row['Genre']}</p>";
            echo "<p><strong>Language:</strong> {$row['Language']}</p>";
            echo "<p><strong>Format:</strong> {$row['Format']}</p>";
            echo "<p><strong>Available Copies:</strong> {$row['Available']}</p>";
            
            $studentId = $_SESSION['StudentID'];
            $checkoutQuery = "SELECT * FROM checkouts WHERE ItemID = '$digitalID' AND UserID = '$studentId' AND CheckinDate IS NULL";
            $checkoutResult = mysqli_query($con, $checkoutQuery);
            
            if(mysqli_num_rows($checkoutResult) > 0) {
                ?>
                <form action="checkin_digitalitem.php" method="post">
                    <input type="hidden" name="digitalid" value="<?php echo $digitalID; ?>">
                    <input type="submit" name="checkin" value="Check In">
                </form>
                <?php
            } else {
                ?>
                <form action="checkout_digitalitem.php" method="post">
                    <input type="hidden" name="digitalid" value="<?php echo $digitalID; ?>">
                    <input type="submit" name="checkout" value="Check Out">
                </form>
                <?php
            }
        } else {
            echo "<p>No details found for the provided digital item ID.</p>";
        }
        mysqli_close($con);
    } else {
        echo "<p>No digital item ID provided.</p>";
    }
    ?>
</div>
<p><a style="margin-left:320px;" href="home.php">Back to Home</a></p>
</body>
</html>
