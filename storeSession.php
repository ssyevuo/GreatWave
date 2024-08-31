<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO sessions (trainer, date, time, location, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $trainer, $date, $time, $location, $_SESSION['user_id']);  // Assuming you have a session user_id

    if ($stmt->execute()) {
        echo "Session booked successfully!";
    } else {
        echo "Error booking session: " . $conn->error;
    }

    $stmt->close();
}
?>
