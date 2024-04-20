<?php
$con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['event_name'];
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $location = $_POST['location'];
    $categories = $_POST['categories'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $maxAttendees = $_POST['max_attendees'];

    $sql = "INSERT INTO events (EventName, Date, StartTime, EndTime, Location, Categories, Description, Type, MaxAttendees) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        die('Error: ' . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, 'ssssssssi', $eventName, $date, $startTime, $endTime, $location, $categories, $description, $type, $maxAttendees);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error: ' . mysqli_stmt_error($stmt));
    }

    echo "Event added successfully";

    mysqli_stmt_close($stmt);
}

mysqli_close($con);