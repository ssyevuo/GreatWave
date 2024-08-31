<?php
include 'db.php';

$sql = "SELECT id, name, email, phone, role FROM users WHERE role='trainer'";
$result = $conn->query($sql);

$trainers = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
}

echo json_encode($trainers);

$conn->close();