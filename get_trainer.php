<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT id, name, email, phone, role FROM users WHERE id=$id";
$result = $conn->query($sql);

$trainer = $result->fetch_assoc();

echo json_encode($trainer);

$conn->close();
