<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
</head>
<body>
    <h2>Delete Book</h2>
    <form action="staff_confirm_delete_book.php" method="post">
        ISBN: <input type="number" name="ISBN" required><br>
        <input type="submit" value="Delete">
        <a href="staff_view_books.php" class="button">Back</a>
    </form>
</body>
</html>