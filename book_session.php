<?php
include 'db.php';

$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];

// Query to book the session (decrease availability)
$query = "UPDATE sessions SET availability = availability - 1 WHERE date = ? AND time = ? AND location = ? AND availability > 0";
$stmt = $conn->prepare($query);
$stmt->bind_param('sss', $date, $time, $location);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $response = ['success' => true];
} else {
    $response = ['success' => false];
}

$stmt->close();
$conn->close();

echo json_encode($response);
