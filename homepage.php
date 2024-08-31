<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] != 'surfer') {
    header("Location: login.html");
    exit;
}

$userName = isset($_SESSION["userName"]) ?$_SESSION["userName"] : 'User';
$firstName = explode(" ", $userName)[0]; //gets the first name

//confirm if the welcome message has already been shown
$showWelcomeMessage = false;
if (!isset($_SESSION["welcomeShown"])) {
    $showWelcomeMessage = true;
    $_SESSION["welcomeShown"] = true;
}
?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Great Wave KE</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="Logo.png" alt="GreatWave Logo">
            </div>
            <?php
                if($showWelcomeMessage):
            ?>
            <div class="welcome-message">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
            <?php
                endif;
            ?>
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
                <a href="userprofile.html" id="profileLink"><i class="fas fa-user"></i> <?php echo htmlspecialchars($firstName); ?></a>
                <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>       
        </header>
        <div class="slideshow-container">
            <div class="mySlideshow fade">
                <img src="image1.jpg" style="width:100%">
            </div>
            <div class="mySlideshow fade">
                <img src="image2.jpg" style="width:100%">
            </div>
            <div class="mySlideshow fade">
                <img src="image3.jpg" style="width:100%">
            </div>
            <div class="mySlideshow fade">
                <img src="image5.jpg" style="width:100%">
            </div>
        </div>
        <br>
        <div style="text-align:center">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
        <div class="main-banner-content">
            <h1>Find the best Surfing Trainers Near You!</h1>
            <div class="filters">
                    <form action="findtrainer2.php" method="GET">
                        <input type="text" name="location" placeholder="Enter your location" id="location">
                        <button type="submit">Search</button>
                    </form>
                </div>
        </div>
        <section class="section featured-trainers">
            <h2>Featured Trainers</h2>
            <div class="trainer-container">
                <div class="trainer-box">
                    <img src="trainer3.jpg" alt="Trainer 1">
                    <h3>Trainer Name 1</h3>
                    <p>Turn fear into fun with your triner, your expert coach for big waves and thrilling sessions</p>
                    <a href="booking.php" class="book-now">Book Now</a>
                </div>
                <div class="trainer-box">
                    <img src="trainer2.jpg" alt="Trainer 2">
                    <h3>Trainer Name 2</h3>
                    <p>Turn fear into fun with your triner, your expert coach for big waves and thrilling sessions</p>
                    <a href="booking.php" class="book-now">Book Now</a>
                </div>
                <div class="trainer-box">
                    <img src="trainer.jpg" alt="Trainer 3">
                    <h3>Trainer Name 3</h3>
                    <p>Turn fear into fun with your triner, your expert coach for big waves and thrilling sessions</p>
                    <a href="booking.php" class="book-now">Book Now</a>
                </div>
                <div class="trainer-box">
                    <img src="trainer4.jpg" alt="Trainer 4">
                    <h3>Trainer Name 4</h3>
                    <p>Turn fear into fun with your triner, your expert coach for big waves and thrilling sessions</p>
                    <a href="booking.php" class="book-now">Book Now</a>
                </div>
                <div class="trainer-box">
                    <img src="trainer5.jpg" alt="Trainer 5">
                    <h3>Trainer Name 5</h3>
                    <p>Turn fear into fun with your triner, your expert coach for big waves and thrilling sessions</p>
                    <a href="booking.php" class="book-now">Book Now</a>
                </div>
            </div>
        </section>
        <section class="section how-it-works">
            <h2>How It Works</h2>
            <p>Find trainers, book sessions, and hit the waves in just a few easy steps!</p>
            <div class="steps-container">
                <div class="steps">
                    <i class="fas fa-search fa-3x"></i>
                    <h3>Find your Trainer</h3>
                    <p>Enter your location and browse profiles of experienced surf trainers around you.</p>
                </div>
                <div class="steps">
                    <i class="fas fa-calendar-alt fa-3x"></i>
                    <h3>Book a Session</h3>
                    <p>Choose a trainer, select a date, and easily book your surf session.</p>
                </div>
                <div class="steps">
                    <i class="fas fa-cloud-sun fa-3x"></i>
                    <h3>Check Surf Conditions</h3>
                    <p>Ensure the conditions are favorable with our up-to-date surf weather forecasts.</p>
                </div>
                <div class="steps">
                    <i class="fas fa-water fa-3x"></i>
                    <h3>Enjoy Your Surf</h3>
                    <p>Meet your trainer and enjoy an unforgettable surfing experience.</p>
                </div>
            </div>
            <div class="call-to-action">
                <p>Ready to begin your surfing journey?</p>
                <a href="findtrainer2.html" class="btn">Find your Trainer</a>
            </div>
        </section>
        <section class="section user-testimonials">
            <h2>What Our Users Say</h2>
            <p>Hear from some of our happy surfers!</p>
            <div class="testimonials-container">
                <div class="testimonials">
                    <img src="testimonial1.jpg" alt="Joyrita Miano" class="user-photo">
                    <p>"Finding a surf trainer has  never been easier. The booking process was seamless and my session was amazing!"</p>
                    <h3>Joyrita Miano</h3>
                </div>
                <div class="testimonials">
                    <img src="testimonial1.jpg" alt="Joyrita Miano" class="user-photo">
                    <p>"Finding a surf trainer has  never been easier. The booking process was seamless and my session was amazing!"</p>
                    <h3>Joyrita Miano</h3>
                </div>
                <div class="testimonials">
                    <img src="testimonial1.jpg" alt="Joyrita Miano" class="user-photo">
                    <p>"Finding a surf trainer has  never been easier. The booking process was seamless and my session was amazing!"</p>
                    <h3>Joyrita Miano</h3>
                </div>
            </div>
            <div class="call-to-action">
                <p>Ready to begin your surfing journey?</p>
                <a href="findtrainer2.html" class="btn">Find your Trainer</a>
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
                <p> 2024 @ GreatWave. All Rights Reserved.</p>
            </div>
        </footer>
        <script src="script.js"></script>
    </body>
</html>