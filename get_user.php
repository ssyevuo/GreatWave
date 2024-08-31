<?php
include 'db.php';

// Get the user ID from the URL parameters
$id = $_GET['id'];

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, name, email, phone, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the user's data
$user = $result->fetch_assoc();

// Check if user exists
if ($user) {
    // Return user data as JSON
    echo json_encode($user);
} else {
    // Return an error message if user not found
    echo json_encode(['error' => 'User not found']);
}

// Close the statement and the connection
$stmt->close();
$conn->close();

