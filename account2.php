<?php
include 'navbar2.php';
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
    header("Location: prof_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="/account2.css">
</head>
<body>
<div class="homeContent">
    <div class="logout">
        <a class="logoutText" href="logout.php">Logout</a>
    </div>
    <h1 class="welcome">Welcome to Your Account, <?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName']; ?></h1>

    <form action="view_notifications2.php" method="get">
    <input type="submit" value="Notifications" class="button">
    </form>
    <form action="view_book_checkouts2.php" method="get">
        <input type="submit" value="View Book Checkouts" class="button">
    </form>
    <form action="view_digitalitem_checkouts2.php" method="get">
        <input type="submit" value="View Digital Item Checkouts" class="button">
    </form>
    <form action="view_holds2.php" method="get">
        <input type="submit" value="View Holds" class="button">
    </form>
    <form action="history2.php" method="get">
        <input type="submit" value="History" class="button">
    </form>
    <form action="view_transactions2.php" method="get">
        <input type="submit" value="Transactions" class="button">
    </form>
    <form action="view_fines2.php" method="get">
        <input type="submit" value="View Fines" class="button">
    </form>

</div>
</body>
</html>