<?php
include 'db.php';

$sql = "SELECT * FROM contact_submissions ORDER BY submitted_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date Submitted</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["name"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["subject"]. "</td>
                <td>" . $row["message"]. "</td>
                <td>" . $row["submitted_at"]. "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No messages found.";
}

$conn->close();
?>