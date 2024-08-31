<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];

$sql = "INSERT INTO users (name, email, phone, role) VALUES ('$name', '$email', '$phone', '$role')";

$response = array('success' => false);

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
}

echo json_encode($response);

$conn->close();