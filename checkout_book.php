<?php
session_start();

if(isset($_SESSION['StudentID']) && !empty($_SESSION['StudentID'])) {
    $studentId = $_SESSION['StudentID'];

    $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $queryCheckCount = "SELECT COUNT(*) AS num_checked_out FROM checkouts WHERE UserID = '$studentId' AND CheckInDate IS NULL";
    $resultCheckCount = mysqli_query($con, $queryCheckCount);
    $rowCheckCount = mysqli_fetch_assoc($resultCheckCount);
    $numCheckedOut = $rowCheckCount['num_checked_out'];

    if($numCheckedOut >= 2) {
        echo "<p>You have already checked out the maximum number of books allowed.</p>";
    } else {
        if(isset($_POST['isbn']) && !empty($_POST['isbn'])) {
            $isbn = $_POST['isbn'];

            $returnDate = date("Y-m-d", strtotime("+7 days"));
            $checkoutDate = date("Y-m-d");

            $queryCheck = "SELECT available, Stock FROM books WHERE ISBN = '$isbn'";
            $resultCheck = mysqli_query($con, $queryCheck);

            if(mysqli_num_rows($resultCheck) > 0) {
                $row = mysqli_fetch_assoc($resultCheck);
                $available = $row['available'];
                $stock = $row['Stock'];

                if($available > 0 && $available <= $stock) {
                    $queryInsert = "INSERT INTO checkouts (ItemID, ItemType, UserID, CheckoutDate, ReturnDate) VALUES ('$isbn', 'Book','$studentId', '$checkoutDate', '$returnDate')";
                    $resultInsert = mysqli_query($con, $queryInsert);

                    if($resultInsert) {
                        $queryUpdate = "UPDATE books SET available = available - 1 WHERE ISBN = '$isbn'";
                        $resultUpdate = mysqli_query($con, $queryUpdate);

                        if($resultUpdate) {
                            echo "<p>Book checked out successfully!</p>";
                        } else {
                            echo "<p>Failed to update book availability.</p>";
                        }
                    } else {
                        echo "<p>Failed to check out the book.</p>";
                    }
                } else {
                    echo "<p>The book is no longer available for checkout.</p>";
                }
            } else {
                echo "<p>Book not found.</p>";
            }
        } else {
            echo "<p>No ISBN provided.</p>";
        }
    }

    mysqli_close($con);
} else {
    echo "<p>Student ID not found in the session.</p>";
}
?>
<p><a href="home.php">Back to Home</a></p>
