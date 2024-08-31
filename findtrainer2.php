<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Find a Trainer</title>
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
                    <a href="bookiboong.php">Book Sessions</a>                    
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
        <main>
            <section class="search-filters">
                <h2>Find Your Perfect Trainer</h2>
                <div class="filters">
                    <form action="findtrainer2.php" method="GET">
                        <input type="text" name="location" placeholder="Enter your location" id="location">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </section>
            <section class="trainer-listings">
                <?php
                include 'db.php';
                //confirm location is not empty
                $location = isset($_GET['location']) ? $conn->real_escape_string($_GET['location']) : '';

                if (!empty($location)) {
                    //Fetches trainers according to the set location
                    $query = "SELECT name, bio, profile_picture FROM trainers WHERE location LIKE '%$location%'";
                } else {
                    //fetch all trainers incase no location has been provided
                    $query = "SELECT name, bio, profile_picture FROM trainers";
                }

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = htmlspecialchars($row['profile_picture']);
                        echo '<div class="trainer-card">';
                        echo '<img src="' . $imagePath . '"alt="Trainer Image">';
                        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                        echo '<p>⭐⭐⭐⭐⭐</p>';
                        echo '<p>' . htmlspecialchars($row['bio']) . '</p>';
                        echo '<p>Ksh.5000 per session</p>';
                        echo '<button class="book-now">Book Now</button>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No trainers found.</p>';
                }

                $conn->close();
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
        <script src="script.js"></script>
    </body>
</html>