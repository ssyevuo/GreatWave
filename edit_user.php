<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];

$sql = "UPDATE users SET name='$name', email='$email', phone='$phone', role='$role' WHERE id=$id";

$response = array('success' => false);

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
}

echo json_encode($response);

$conn->close();