<?php
include 'db.php';

$sql = "SELECT * FROM sessions";
$result = $conn->query($sql);

$sessions = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
}

echo json_encode($sessions);

$conn->close();
?>
