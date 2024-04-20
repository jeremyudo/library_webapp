<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Digital Item</title>
</head>
<body>
    <?php
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');

    $DigitalID = mysqli_real_escape_string($con, $_POST['DigitalID']);

    $sql = "SELECT * FROM digitalitems WHERE DigitalID = '$DigitalID'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $digitalItemData = mysqli_fetch_assoc($result);
        ?>
        <h2>Confirm Delete Digital Item</h2>
        <h3>Digital Item Information:</h3>
        <p><strong>Digital ID:</strong> <?php echo $digitalItemData['DigitalID']; ?></p>
        <p><strong>Title:</strong> <?php echo $digitalItemData['Title']; ?></p>
        <p><strong>Author/Artist:</strong> <?php echo $digitalItemData['Author']; ?></p>
        <p><strong>Format:</strong> <?php echo $digitalItemData['Format']; ?></p>
        <p><strong>Publisher/Studio:</strong> <?php echo $digitalItemData['Publisher']; ?></p>
        <p><strong>Publication Year:</strong> <?php echo $digitalItemData['PublicationYear']; ?></p>
        <p><strong>Genre:</strong> <?php echo $digitalItemData['Genre']; ?></p>
        <p><strong>Description:</strong> <?php echo $digitalItemData['Description']; ?></p>
        <p><strong>Language:</strong> <?php echo $digitalItemData['Language']; ?></p>
        <p><strong>Cover Image:</strong> <?php echo $digitalItemData['CoverImage']; ?></p>
        <p><strong>Stock:</strong> <?php echo $digitalItemData['Stock']; ?></p>
        <form action="remove_digitalitem.php" method="post">
            <input type="hidden" name="DigitalID" value="<?php echo $DigitalID; ?>">
            <button type="submit">Yes, Delete Digital Item</button>
        </form>
        <form action="delete_digitalitem.php" method="post">
            <button type="submit">No, Go Back</button>
        </form>
    <?php
    } else {
        echo "Digital item not found.";
    }

    mysqli_close($con);
    ?>
</body>
</html>
