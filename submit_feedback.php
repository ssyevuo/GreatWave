<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback_text = isset($_POST['feedback_text']) ? $conn->real_escape_string($_POST['feedback_text']) : '';

    if (empty($feedback_text)) {
        die("Error: Feedback text is empty.");
    }

    $query = "INSERT INTO feedback (user_id, feedback_text) VALUES ('$user_id', '$feedback_text')";
    
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href = 'feedback.html';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
    $conn->close();
}

