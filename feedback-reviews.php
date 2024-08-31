<?php
session_start();
include 'db.php';

// Fetch all feedback from the feedback table
$query = "SELECT users.name AS user_name, feedback.feedback_text, feedback.created_at 
          FROM feedback 
          JOIN users ON feedback.user_id = users.id 
          ORDER BY feedback.created_at DESC";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
    <header>
            <div class="logo">
                <img src="Logo.png" alt="GreatWave Logo">
            </div>
            <div class="nav-container">
                <nav>
                    <a href="user-management.html">User Management</a>
                    <a href="trainer-management.html">Trainer Management</a>
                    <a href="session-management.html">Session Management</a>
                    <a href="feedback-reviews.php">Feedback & Reviews</a>
                </nav>
            </div>
            <div class="user-options">
                <a href="admin_profile.html" id="profileLink"><i class="fas fa-user"></i> Profile</a>
                <a href="logout.html" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        <main>
            <section class="ufeedback-section">
                <h2>User's Feedback and Reviews</h2>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="ufeedback-card">';
                        echo '<h3>' . htmlspecialchars($row['user_name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($row['feedback_text']) . '</p>';
                        echo '<small>' . htmlspecialchars($row['created_at']) . '</small>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No feedback available.</p>';
                }
                ?>
            </section>
        </main>
        <footer>
            <div class="footer-container">
                <div class="footer-section logo-tagline">
                    <img src="Logo.png" alt="Great Wave Logo">
                </div>
                <div class="footer-section links">
                    <h3>Information</h3>
                    <a href="#">About Us</a>
                    <a href="#">Testimonials</a>
                    <a href="#">How It Works</a>
                    <a href="#">Blog</a>
                </div>
                <div class="footer-section links">
                    <h3>Our Services</h3>
                    <a href="#">Trainers</a>
                    <a href="#">Book a Session</a>
                    <a href="#">Weather Updates</a>
                    <a href="#">Surfing Tips</a>
                </div>
                <div class="footer-section contact">
                    <h3>Contact Us</h3>
                    <p>Phone: +254 711 111 111</p>
                    <p>Email: great@wave.com</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p> 2024 @ GreatWave. All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>
<?php
$conn->close();
?>