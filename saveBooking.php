<?php
session_start();
include 'db.php'; // Ensure you have a file to connect to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $user_id = $_SESSION['user_id']; 

    $stmt = $conn->prepare("INSERT INTO sessions (user_id, trainer_name, session_date, session_time, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $trainer, $date, $time, $location);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
