<?php
#include 'navbar.php';

$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, 'library');

function sanitize_input($data) {
    if ($data === null) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$message = "";
$titlePlaceholder = "Enter Title";
$authorsPlaceholder = "Enter Authors";
$publisherPlaceholder = "Enter Publisher";
$publicationDatePlaceholder = "Enter Publication Date";
$pageCountPlaceholder = "Enter Page Count";
$descriptionPlaceholder = "Enter Description";
$coverImageURLPlaceholder = "Enter Cover Image URL";
$stockPlaceholder = "Enter Stock";
$numberAvailablePlaceholder = "Enter Number Available";
$numberCheckoutPlaceholder = "Enter Number Checkout";
$numberHeldPlaceholder = "Enter Number Held";
$costPlaceholder = "Enter Cost";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = isset($_POST['ISBN']) ? sanitize_input($_POST['ISBN']) : '';

    $query = "SELECT * FROM books WHERE ISBN = '$isbn'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die('Error executing query: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['Title'];
        $authors = $row['Authors'];
        $publisher = $row['Publisher'];
        $publicationDate = $row['PublicationDate'];
        $pageCount = $row['PageCount'];
        $description = $row['Description'];
        $coverImageURL = $row['CoverImageURL'];
        $stock = $row['Stock'];
        $numberAvailable = $row['NumberAvailable'];
        $numberCheckout = $row['NumberCheckedOut'];
        $numberHeld = $row['NumberHeld'];
        $cost = $row['Cost'];
        $message = "ISBN $isbn exists in the database.";
        $titlePlaceholder = $title;
        $authorsPlaceholder = $authors;
        $publisherPlaceholder = $publisher;
        $publicationDatePlaceholder = $publicationDate;
        $pageCountPlaceholder = $pageCount;
        $descriptionPlaceholder = $description;
        $coverImageURLPlaceholder = $coverImageURL;
        $stockPlaceholder = $stock;
        $numberAvailablePlaceholder = $numberAvailable;
        $numberCheckoutPlaceholder = $numberCheckout;
        $numberHeldPlaceholder = $numberHeld;
        $costPlaceholder = $cost;
    } else {
        $message = "ISBN $isbn does not exist in the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="data_form.css">
</head>
<body>

    <h2 id="header">Update Book</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        ISBN: <input type="text" name="ISBN" required><br>
        <input type="submit" value="Check ISBN">
        <a href="admin_view_books.php" class="button">Back</a>
    </form>

    <?php
    if(isset($message)) {
        echo "<div id='messageContainer'><p id='message'>$message</p></div>";
        echo "<script>setTimeout(function() { document.getElementById('messageContainer').style.display = 'none'; }, 1000);</script>";
    }
    ?>

    <?php
    if(isset($title) && isset($authors)) {
        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
        echo "<input type='hidden' name='ISBN' value='$isbn'>";
        echo "Title: <input type='text' name='Title' value='' placeholder='$titlePlaceholder'><br>";
        echo "Authors: <input type='text' name='Authors' value='' placeholder='$authorsPlaceholder'><br>";
        echo "Publisher: <input type='text' name='Publisher' value='' placeholder='$publisherPlaceholder'><br>";
        echo "Publication Date: <input type='date' name='PublicationDate' value='' placeholder='$publicationDatePlaceholder'><br>";
        echo "Page Count: <input type='number' name='PageCount' value='' placeholder='$pageCountPlaceholder'><br>";
        echo "Description: <input type='text' name='Description' value='' placeholder='$descriptionPlaceholder'><br>";
        echo "Cover Image URL: <input type='text' name='CoverImageURL' value='' placeholder='$coverImageURLPlaceholder'><br>";
        echo "Stock: <input type='number' name='Stock' value='' placeholder='$stockPlaceholder'><br>";
        echo "Number Available: <input type='number' name='NumberAvailable' value='' placeholder='$numberAvailablePlaceholder'><br>";
        echo "Number Checked Out: <input type='number' name='NumberCheckout' value='' placeholder='$numberCheckoutPlaceholder'><br>";
        echo "Number Held: <input type='number' name='NumberHeld' value='' placeholder='$numberHeldPlaceholder'><br>";
        echo "Cost: <input type='text' name='Cost' value='' placeholder='$costPlaceholder'><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    }
    ?>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Title']) && isset($_POST['Authors'])) {
    $isbn = sanitize_input($_POST['ISBN']);
    $title = sanitize_input($_POST['Title']);
    $authors = sanitize_input($_POST['Authors']);
    $publisher = sanitize_input($_POST['Publisher']);
    $publicationDate = sanitize_input($_POST['PublicationDate']);
    $pageCount = sanitize_input($_POST['PageCount']);
    $description = sanitize_input($_POST['Description']);
    $coverImageURL = sanitize_input($_POST['CoverImageURL']);
    $stock = sanitize_input($_POST['Stock']);
    $numberAvailable = sanitize_input($_POST['NumberAvailable']);
    $numberCheckout = sanitize_input($_POST['NumberCheckout']);
    $numberHeld = sanitize_input($_POST['NumberHeld']);
    $cost = sanitize_input($_POST['Cost']);

    $sql = "UPDATE books SET ";

    if (!empty($title)) {
        $sql .= "Title='$title', ";
    }
    if (!empty($authors)) {
        $sql .= "Authors='$authors', ";
    }
    if (!empty($publisher)) {
        $sql .= "Publisher='$publisher', ";
    }
    if (!empty($publicationDate)) {
        $sql .= "PublicationDate='$publicationDate', ";
    }
    if (!empty($pageCount)) {
        $sql .= "PageCount='$pageCount', ";
    }
    if (!empty($description)) {
        $sql .= "Description='$description', ";
    }
    if (!empty($coverImageURL)) {
        $sql .= "CoverImageURL='$coverImageURL', ";
    }
    if (!empty($stock)) {
        $sql .= "Stock='$stock', ";
    }
    if (!empty($numberAvailable)) {
        $sql .= "NumberAvailable='$numberAvailable', ";
    }
    if (!empty($numberCheckout)) {
        $sql .= "NumberCheckout='$numberCheckout', ";
    }
    if (!empty($numberHeld)) {
        $sql .= "NumberHeld='$numberHeld', ";
    }
    if (!empty($cost)) {
        $sql .= "Cost='$cost', ";
    }

    $sql .= "UpdatedDate='" . date('Y-m-d H:i:s') . "' ";

    $sql = rtrim($sql, ", ");

    $sql .= " WHERE ISBN='$isbn'";

    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }

    echo "<div id='success_message'>Updated successfully</div>";
    echo "<script>setTimeout(function() { document.getElementById('success_message').style.display = 'none'; }, 500);</script>";

    header("refresh:2;url=admin_view_books.php");
    exit();
}

mysqli_close($con);
?>
