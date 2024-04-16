<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Digital Item</title>
</head>
<body>

    <h2>Update Digital Item</h2>

    <form action="revise_digitalitem.php" method="post">
        Digital ID: <input type="number" name="DigitalID" required><br>
        Stock: <input type="number" name="Stock"><br>
        Title: <input type="text" name="Title"><br>
        Author/Artist: <input type="text" name="Author"><br>
        Format: 
        <select name="Format">
            <option value="">Select Format</option>
            <option value="DVD">DVD</option>
            <option value="eBook">eBook</option>
            <option value="Audio Book">Audio Book</option>
        </select><br>
        Publisher/Studio: <input type="text" name="Publisher"><br>
        Publication Year: <input type="number" name="PublicationYear" min="1800" max="2024" /><br>
        Genre: 
        <select name="Genre">
            <option value="">Select Genre</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Biography">Biography</option>
            <option value="Children">Children</option>
            <option value="Comedy">Comedy</option>
            <option value="Cookbook">Cookbook</option>
            <option value="Crime">Crime</option>
            <option value="Documentary">Documentary</option>
            <option value="Drama">Drama</option>
            <option value="Family">Family</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Fiction">Fiction</option>
            <option value="History">History</option>
            <option value="Horror">Horror</option>
            <option value="Music">Music</option>
            <option value="Musical">Musical</option>
            <option value="Mystery">Mystery</option>
            <option value="Non-Fiction">Non-Fiction</option>
            <option value="Poetry">Poetry</option>
            <option value="Romance">Romance</option>
            <option value="Science Fiction">Science Fiction</option>
            <option value="Self-Help">Self-Help</option>
            <option value="Sport">Sport</option>
            <option value="Thriller">Thriller</option>
            <option value="War">War</option>
            <option value="Western">Western</option>
            <option value="Young Adult">Young Adult</option>
            <option value="Other">Other</option>
        </select><br>
        Description: <input type="text" name="Description"><br>
        Language: 
        <select name="Language">
            <option value="">Select Language</option>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="Arabic">Arabic</option>
            <option value="Chinese">Chinese</option>
            <option value="Russian">Russian</option>
        </select><br>
        Cover Image: <input type="text" name="CoverImage"><br>
        Stock: <input type="number" name="Stock"><br>
        <input type="submit" value="Update">
    </form>

</body>
</html>
