<?php
include 'db.php';

//getting the role 
$role = isset($_GET['role']) ? $_GET['role'] : '';

// Prepare the SQL statement
if ($role) {
    $sql = "SELECT id, name, email, phone, role FROM users WHERE role=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $role);
} else {
    $sql = "SELECT id, name, email, phone, role FROM users";
    $stmt = $conn->prepare($sql);
}

// Error handling for SQL statement preparation
if ($stmt === false) {
    die(json_encode(['error' => 'Failed to prepare SQL statement']));
}

//execute statement
if (!$stmt->execute()) {
    die(json_encode(['error' => 'Failed to execute SQL statement']));
}

$result = $stmt->get_result();

// Fetch all users
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');

// Return users as JSON
echo json_encode($users);

// Close the connection
$stmt->close();
$conn->close();
