<?php
include 'db.php';

//get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query) {
    $stmt = $conn->prepare("SELECT * FROM sessions WHERE location LIKE ?");
    $likeQuery = "%" . $query . "%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();

    $result = $stmt->get_result();
    $sessions = [];

    while ($row = $result->fetch_assoc()) {
        $sessions[] = [
            'title' => $row['title'],
            'description' => $row['description'],
            'date' => $row['date'],
            'location' => $row['location']
        ];
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($sessions);
} else {
    echo json_encode([]);
}