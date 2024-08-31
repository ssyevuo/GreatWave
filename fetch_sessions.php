<?php
include 'db.php';

$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];

$query = "SELECT * FROM sessions WHERE date = ? AND time = ? AND location LIKE ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$likeLocation = "%".$location."%";
$stmt->bind_param('sss', $date, $time, $likeLocation);
$stmt->execute();
$result = $stmt->get_result();

$sessions = array();
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($sessions);
