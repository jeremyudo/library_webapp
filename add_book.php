<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="data_form.css">
    <style>
        #header {
            text-align: center;
        }

        textarea[name="Description"] {
            height: 100px;
        }

        .required::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }

        .button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<form action="" method="post">
    <h2 id="header">Add New Book</h2>
    <label for="ISBN">ISBN: <span class="required"></span></label>
    <input type="number" name="ISBN" required>
    <label for="Title">Title: <span class="required"></span></label>
    <input type="text" name="Title" required>
    <label for="Authors">Authors: <span class="required"></span></label>
    <input type="text" name="Authors" required>
    <label for="Publisher">Publisher: <span class="required"></span></label>
    <input type="text" name="Publisher" required>
    <label for="PublicationDate">Publication Date: <span class="required"></span></label>
    <input type="date" name="PublicationDate" required>
    Genre: <span class="required"></span>
    <select name="Genre" required>
        <option value="">Select Genre</option>
        <option value="Fiction">Fiction</option>
        <option value="Non-fiction">Non-fiction</option>
    </select><br>
    Language: <span class="required"></span>
    <select name="Language" required>
        <option value="">Select Language</option>
        <option value="English">English</option>
        <option value="Spanish">Spanish</option>
    </select><br>
    <label for="PageCount">Page Count:</label>
    <input type="number" name="PageCount">
    <label for="Description">Description:</label>
    <textarea name="Description"></textarea>
    <label for="Format">Format: <span class="required"></span></label>
    <select name="Format" required>
        <option value="">Select Format</option>
        <option value="Paper">Paper</option>
        <option value="Audio Book">Audio Book</option>
        <option value="eBook">eBook</option>
    </select>
    <label for="CoverImageURL">Cover Image URL:</label>
    <input type="text" name="CoverImageURL">
    <label for="Stock">Stock: <span class="required"></span></label>
    <input type="number" name="Stock" required>
    <label for="Cost">Cost:</label>
    <input type="text" name="Cost">
    <input type="submit" name="submit" value="Add Book" class="button">
    <a href="admin_view_books.php" class="button">Back</a>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $_POST['NumberAvailable'] = $_POST['Stock'];
    $_POST['NumberCheckedOut'] = 0;
    $_POST['NumberHeld'] = 0;

    $sql = "INSERT INTO books (ISBN, Title, Authors, Publisher, PublicationDate, Genre, Description, Language, PageCount, CoverImageURL, Stock, NumberAvailable, NumberCheckedOut, NumberHeld, Cost) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        die('Error: ' . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, 'isssisssisiiidd', $_POST['ISBN'], $_POST['Title'], $_POST['Authors'], $_POST['Publisher'], $_POST['PublicationDate'], $_POST['Genre'], $_POST['Description'], $_POST['Language'], $_POST['PageCount'], $_POST['CoverImageURL'], $_POST['Stock'], $_POST['NumberAvailable'], $_POST['NumberCheckedOut'], $_POST['NumberHeld'], $_POST['Cost']);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error: ' . mysqli_stmt_error($stmt));
    }

    echo "1 book record added";
    header("Location: admin_view_books.php");

    mysqli_stmt_close($stmt);

    mysqli_close($con);
}
?>
</body>
</html>
