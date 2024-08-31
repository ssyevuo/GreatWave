<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] != 'trainer') {
    header("Location: login.html");
    exit;
}
$userName = isset($_SESSION["userName"]) ? $_SESSION["userName"] : 'User';
$firstName = explode(" ", $userName)[0]; //gets the first name
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="GreatWave Logo">
        </div>
        <div class="welcome-message">
            Welcome, <?php echo htmlspecialchars($userName); ?>
        </div>
        <div class="nav-container">
            <nav>
                <a href="trainer_dashboard.php">Dashboard</a>
                <a href="trainer_calendar.html">Calendar</a>
                <a href="trainer_feedback.html">Feedback & Review</a>
                <a href="trainer_notification.html">Notification</a>
            </nav>
        </div>
        <div class="user-options">
            <a href="trainer_profile.html" id="profileLink"><i class="fas fa-user"></i> <?php echo htmlspecialchars($firstName); ?></a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </header>
    <section class="session-management-section">
        <div class="session-management-container">
            <h1>Session Management</h1>
            <div class="session-actions">
                <button class="btn" id="addSessionBtn" onclick="addSession()">Add New Session</button>
                <button class="btn" id="manageBookingsBtn" onclick="manageBookings()">Manage Bookings</button>
            </div>
            <div class="session-list">
                <h2>Upcoming Sessions</h2>
                <div class="user-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Surfer Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessionTableBody"> 
                        <!-- Sessions will be loaded here via JS -->
                    </tbody>
                </table>
            </div>
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

    <!-- Session Form Modal-->
    <div id="sessionFormModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="formTitle">Add Session</h2>
            <form id="sessionForm">
                <label for="user_id">User ID: </label>
                <input type="number" id="user_id" name="user_id" required>

                <label for="trainer_name">Trainer Name: </label>
                <input type="text" id="trainer_name" name="trainer_name" required>

                <label for="session_date">Date: </label>
                <input type="date" id="session_date" name="session_date" required>

                <label for="session_time">Time: </label>
                <input type="time" id="session_time" name="session_time" required>

                <label for="location">Location: </label>
                <input type="text" id="location" name="location" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>