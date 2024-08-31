<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id";

$response = array('success' => false);

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
}

echo json_encode($response);

$conn->close();