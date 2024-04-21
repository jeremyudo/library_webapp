<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Book</title>
</head>
<body>
    <?php
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    mysqli_select_db($con, 'library');

    $ISBN = mysqli_real_escape_string($con, $_POST['ISBN']);

    $sql = "SELECT * FROM books WHERE ISBN = '$ISBN'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $bookData = mysqli_fetch_assoc($result);
        ?>
        <h2>Confirm Delete Book</h2>
        <h3>Book Information:</h3>
        <p><strong>ISBN:</strong> <?php echo $bookData['ISBN']; ?></p>
        <p><strong>Title:</strong> <?php echo $bookData['Title']; ?></p>
        <p><strong>Author:</strong> <?php echo $bookData['Author']; ?></p>
        <p><strong>Publisher:</strong> <?php echo $bookData['Publisher']; ?></p>
        <p><strong>Publication Year:</strong> <?php echo $bookData['PublicationYear']; ?></p>
        <p><strong>Genre:</strong> <?php echo $bookData['Genre']; ?></p>
        <p><strong>Description:</strong> <?php echo $bookData['Description']; ?></p>
        <p><strong>Language:</strong> <?php echo $bookData['Language']; ?></p>
        <p><strong>Cover Image:</strong> <?php echo $bookData['CoverImage']; ?></p>
        <p><strong>Stock:</strong> <?php echo $bookData['Stock']; ?></p>
        <p><strong>Page Count:</strong> <?php echo $bookData['PageCount']; ?></p>
        <p><strong>Format:</strong> <?php echo $bookData['Format']; ?></p>
        <form action="staff_remove_book.php" method="post">
            <input type="hidden" name="ISBN" value="<?php echo $ISBN; ?>">
            <button type="submit">Yes, Delete Book</button>
        </form>
        <form action="staff_delete_book.php" method="post">
            <button type="submit">No, Go Back</button>
        </form>
    <?php
    } else {
        echo "Book not found.";
    }

    mysqli_close($con);
    ?>
</body>
</html>