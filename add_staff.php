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

        /* Additional styling for the PageCount field */
        textarea[name="Description"] {
            height: 100px; /* Adjust the height as needed */
        }
    </style>
</head>
<body>

<!-- Add new book form -->
<form action="insert_book.php" method="post">
    <h2 id="header">Add New Book</h2>
    <label for="ISBN">ISBN: <span>*</span></label>
    <input type="number" name="ISBN" required>
    <label for="Title">Title: <span>*</span></label>
    <input type="text" name="Title" required>
    <label for="Author">Author: <span>*</span></label>
    <input type="text" name="Author" required>
    <label for="Publisher">Publisher:</label>
    <input type="text" name="Publisher">
    <label for="PublicationYear">Publication Year: <span>*</span></label>
    <input type="number" name="PublicationYear" required min="1800" max="2024">
    <label for="Genre">Genre: <span>*</span></label>
    <select name="Genre" required>
        <option value="">Select Genre</option>
        <option value="Adventure">Adventure</option>
        <option value="Biography">Biography</option>
        <option value="Children">Children</option>
        <option value="Cookbook">Cookbook</option>
        <option value="Drama">Drama</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Fiction">Fiction</option>
        <option value="Historical Fiction">Historical Fiction</option>
        <option value="Horror">Horror</option>
        <option value="Mystery">Mystery</option>
        <option value="Non-Fiction">Non-Fiction</option>
        <option value="Poetry">Poetry</option>
        <option value="Romance">Romance</option>
        <option value="Science Fiction">Science Fiction</option>
        <option value="Self-Help">Self-Help</option>
        <option value="Thriller">Thriller</option>
        <option value="Young Adult">Young Adult</option>
        <option value="Other">Other</option>
    </select>
    <label for="PageCount">Page Count: <span>*</span></label>
    <input type="number" name="PageCount" required>
    <label for="Description">Description: <span>*</span></label>
    <textarea name="Description" required></textarea>
    <label for="Language">Language: <span>*</span></label>
    <select name="Language" required>
        <option value="">Select Language</option>
        <option value="English">English</option>
        <option value="Spanish">Spanish</option>
        <option value="French">French</option>
        <option value="Arabic">Arabic</option>
        <option value="Chinese">Chinese</option>
        <option value="Russian">Russian</option>
    </select>
    <label for="Format">Format: <span>*</span></label>
    <select name="Format" required>
        <option value="">Select Format</option>
        <option value="Paper">Paper</option>
        <option value="Audio Book">Audio Book</option>
        <option value="eBook">eBook</option>
    </select>
    <label for="CoverImage">Cover Image:</label>
    <input type="text" name="CoverImage">
    <label for="Stock">Stock: <span>*</span></label>
    <input type="number" name="Stock" required>
    <label for="NumberAvailable">Number Available:</label>
    <input type="number" name="NumberAvailable">
    <label for="NumberCheckout">Number Checkout:</label>
    <input type="number" name="NumberCheckout">
    <label for="NumberHeld">Number Held:</label>
    <input type="number" name="NumberHeld">
    <label for="Cost">Cost:</label>
    <input type="text" name="Cost">
    <input type="submit" value="Add Book">
</form>

<script>
    window.onload = function() {
        var requiredInputs = document.querySelectorAll('input[required], select[required], textarea[required]');
        requiredInputs.forEach(function(input) {
            var label = document.createElement('label');
            label.textContent = '*';
            label.style.color = 'red'; // Change color as needed
            input.parentNode.insertBefore(label, input.nextSibling);
        });
    };
</script>

</body>
</html>
