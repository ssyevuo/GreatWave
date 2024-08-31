<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in to view your bookings'); window.location.href = 'login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch the user's bookings from the sessions table
$sql = "SELECT session_date, session_time, location, trainer_name 
        FROM sessions 
        WHERE user_id = $user_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
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
                <a href="homepage.php">Home</a>
                <a href="booking.php">Book Sessions</a>                    
                <a href="findtrainer2.php">Find a Trainer</a>
                <a href="weather2.html">Weather</a>
                <a href="mybookings.php">My Bookings</a>
                <a href="feedback.html">Feedback</a>                   
            </nav>
        </div>
        <div class="user-options">
            <a href="userprofile.html" id="profileLink"><i class="fas fa-user"></i> Profile</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>       
    </header>

    <section class="bookings-section">
        <div class="bookings-container">
            <h1>My Bookings</h1>
            <div class="bookings-list">
                <!-- Display bookings here -->
                <?php
                if ($result === false) {
                    // Output the error for debugging
                    echo "Error: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='booking-item'>";
                            echo "<p><strong>Date:</strong> " . $row['session_date'] . "</p>";
                            echo "<p><strong>Time:</strong> " . $row['session_time'] . "</p>";
                            echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                            echo "<p><strong>Trainer:</strong> " . $row['trainer_name'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>You have no bookings yet.</p>";
                    }
                }
                
                $conn->close();
                ?>
            </div>
        </div>
    </section>

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
            <p> 2024@GreatWave. All Rights Reserved.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
