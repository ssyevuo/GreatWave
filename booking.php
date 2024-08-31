<?php
session_start();
$trainers = isset($_SESSION['trainers']) ? $_SESSION['trainers'] : [];
$date = isset($_GET['date']) ? $_GET['date'] : null;
$time = isset($_GET['time']) ? $_GET['time'] : null;
$location = isset($_GET['location']) ? $_GET['location'] : null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Sessions</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.css' rel='stylesheet' />
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.js'></script>
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
        <section class="booking-section">
            <div class="booking-container">
                <h1>Book a Session</h1>
                <form id="filterForm" action="findTrainers.php" method="GET">
                    <div class="filters">
                        <label for="date">Date: </label>
                        <input type="date" id="date" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>" required>
                        <label for="time">Time: </label>
                        <input type="time" id="time" name="time" value="<?php echo isset($_GET['time']) ? $_GET['time'] : ''; ?>" required>
                        <label for="location">Location: </label>
                        <input type="text" id="location" name="location" value="<?php echo isset($_GET['location']) ? $_GET['location'] : ''; ?>" placeholder="Enter location" required>
                        <button class="btn-filter" type="submit">Find Trainer</button>
                    </div>
                </form>
                
                <section class="section available-trainers">
                    <h1>Available Trainers</h1>
                    <div class="trainer-container">
                        <?php if (count($trainers) > 0): ?>
                            <?php foreach ($trainers as $trainer): ?>
                                <div class="trainer-box">
                                    <img src="<?php echo $trainer['profile_picture']; ?>" alt="<?php echo $trainer['name']; ?>">
                                    <h3><?php echo $trainer['name']; ?></h3>
                                    <p><?php echo $trainer['bio']; ?></p>
                                    <a href="#" 
                                       onclick="selectTrainer('<?php echo $trainer['name']; ?>', 
                                                              '<?php echo $date; ?>', 
                                                              '<?php echo $time; ?>', 
                                                              '<?php echo $location; ?>')"
                                       class="btn-book select-now">Select</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No trainers available for the selected date, time, and location.</p>
                        <?php endif; ?>
                    </div>
                </section>

                <div class="session-details">
                    <h2>Session Details</h2>
                    <ul id="sessionDetails">
                        <li>Date: <span id="selectedDate">[Selected Date]</span></li>
                        <li>Time: <span id="selectedTime">[Selected Time]</span></li>
                        <li>Location: <span id="selectedLocation">[Selected Location]</span></li>
                        <li>Trainer: <span id="selectedTrainer">[Selected Trainer]</li>
                        <button class="btn-book" onclick="confirmBooking()">Book Now</button>
                    </ul>
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
                <p> 2024 @ GreatWave. All Rights Reserved.</p>
            </div>
        </footer>
        <script>
            function setMinDateTime() {
            const dateInput = document.querySelector('input[name="date"]');
            const timeInput = document.querySelector('input[name="time"]');
            const now = new Date();
            var year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');

            const minDate = `${year}-${month}-${day}`;
            const minTime = `${hours}:${minutes}`;

            dateInput.value = minDate; // Seting the current date as the default value
            timeInput.value = minTime; // Seting the current time as the default value

            dateInput.min = minDate; // Seting the minimum date to the current date
            timeInput.min = minTime; // Seting the minimum time to the current time
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            setMinDateTime();
        });
            function selectTrainer(name, date, time, location) {
                document.getElementById('selectedTrainer').textContent = name;
                document.getElementById('selectedDate').textContent = date;
                document.getElementById('selectedTime').textContent = time;
                document.getElementById('selectedLocation').textContent = location;
            }

            function confirmBooking() {
                const selectedTrainer = document.getElementById('selectedTrainer').textContent;
                const selectedDate = document.getElementById('selectedDate').textContent;
                const selectedTime = document.getElementById('selectedTime').textContent;
                const selectedLocation = document.getElementById('selectedLocation').textContent;

                if (selectedTrainer && selectedDate && selectedTime && selectedLocation) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'saveBooking.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            const response = xhr.responseText;
                            if (response === 'success') {
                                alert('Session booked successfully!');
                                window.location.href = 'booking.php';
                            } else {
                                alert('Failed to book session: ' + response);
                            }
                        }
                    };
                    xhr.send(`trainer=${encodeURIComponent(selectedTrainer)}&date=${encodeURIComponent(selectedDate)}&time=${encodeURIComponent(selectedTime)}&location=${encodeURIComponent(selectedLocation)}`);
                } else {
                    alert('Please select a trainer and session details before booking.');
                }
            }

        </script>
    </body>
</html>
