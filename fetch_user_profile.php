<?php
session_start();
include('db.php');

// Assuming the user's ID is stored in the session after login
$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode($user);
?>
