<?php
session_start();
include 'db.php';

$trainers = [];

if (isset($_GET['date'], $_GET['time'], $_GET['location'])) {
    $date = $_GET['date'];
    $time = $_GET['time'];
    $location = $_GET['location'];

    $stmt = $conn->prepare("SELECT * FROM trainers WHERE location = ?");
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }

    $stmt->close();
}

// Store the trainers in a session variable
$_SESSION['trainers'] = $trainers;

header("Location: booking.php?date=$date&time=$time&location=$location");
exit;
?>
