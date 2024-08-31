document.addEventListener('DOMContentLoaded', function() {
    try {
        displayFeedback();
    } catch (error) {
        console.error('Error in displayFeedback:', error);
    }

    try {
        displayNotifications();
    } catch (error) {
        console.error('Error in displayNotifications:', error);
    }

    try {
        initializeCalendar();
    } catch (error) {
        console.error('Error in initializeCalendar:', error);
    }

    try {
        hideWelcomeMessage();
    } catch (error) {
        console.error('Error in hideWelcomeMessage:', error);
    }

    try {
        initializeSlideshow();
    } catch (error) {
        console.error('Error in initializeSlideshow:', error);
    }

    try {
        initializeWeather();
    } catch (error) {
        console.error('Error in initializeWeather:', error);
    }

    try {
        initializeBookNow();
    } catch (error) {
        console.error('Error in initializeBookNow:', error);
    }

    try {
        initializeLogout();
    } catch (error) {
        console.error('Error in initializeLogout:', error);
    }

    try {
        displayUsers();
    } catch (error) {
        console.error('Error in displayUsers:', error);
    }

    try {
        displayTrainers();
    } catch (error) {
        console.error('Error in displayTrainers:', error);
    }

    try {
        initializeSearch();
    } catch (error) {
        console.error('Error in initializeSearch:', error);
    }

    try {
        initializeRegistrationForm();
    } catch (error) {
        console.error('Error in initializeRegistrationForm:', error);
    }

    try {
        initializeSessions();
    } catch (error) {
        console.error('Error in initializeSessions:', error);
    }

    try {
        initializeBookSessions();
    } catch(error) {
        console.error('Error in initializeBookSessions:', error);
    }

    try {
        initializeSurfCalendar();
    } catch(error) {
        console.error('Error in initializeSurfCalendar:', error);
    }

    try {
        filterSessions();
    } catch(error) {
        console.error('Error in filterSessions:', error);
    }

    try {
        selectTrainer();
    } catch(error) {
        console.error('Error in selectTrainer:', error);
    }

    try {
        confirmBooking();
    } catch(error) {
        console.error('Error in confirmBooking:', error);
    }
});
function selectTrainer(name, date, time, location) {
    document.getElementById('selectedTrainer').textContent = name;
    document.getElementById('selectedDate').textContent = date;
    document.getElementById('selectedTime').textContent = time;
    document.getElementById('selectedLocation').textContent = location;
}


function initializeSurfCalendar() {
    console.log("Initializing Surf Calendar...");
    let calendarEl = document.getElementById('sessionCalendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            //example of an event
            {
                title: 'Morning Session',
                start: '2024-08-15T08:00:00',
                end: '2024-08-15T10:00:00',
                extendedProps: {
                    location: 'Diani',
                    availability: 5
                }
            }
        ],
        dateClick: function(info) {
            // Handle date clicks here
            console.log(info.dateStr);
        },
        eventClick: function(info) {
            // Handle event clicks to show details and allow booking
            console.log(info.event.title);
            showSessionDetails(info.event);
        }
    });

    calendar.render();
}

// Session Management: Add, Edit, Delete Sessions
function initializeSessions() {
    const sessionTableBody = document.getElementById('sessionTableBody');

    // Fetch and display sessions
    function displaySessions() {
        fetch('fetch_sessions.php')
            .then(response => response.json())
            .then(sessions => {
                sessionTableBody.innerHTML = '';
                sessions.forEach(session => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${session.id}</td>
                        <td>${session.title}</td>
                        <td>${session.location}</td>
                        <td>${session.date}</td>
                        <td>${session.time}</td>
                        <td>${session.availability}</td>
                        <td>
                            <button class="btn edit-trainer" data-id="${session.id}">Edit</button>
                            <button class="btn delete-trainer" data-id="${session.id}">Delete</button>
                        </td>
                    `;
                    sessionTableBody.appendChild(row);
                });

                document.querySelectorAll('.edit-session').forEach(button => {
                    button.addEventListener('click', handleEditSession);
                });

                document.querySelectorAll('.delete-session').forEach(button => {
                    button.addEventListener('click', handleDeleteSession);
                });
            })
            .catch(error => {
                console.error('Error fetching sessions:', error);
                alert('Failed to fetch sessions.');
            });


        fetch('get_sessions.php')
            .then(response => response.json())
            .then(data => {
                let sessionTableBody = document.getElementById('sessionTableBody');
                sessionTableBody.innerHTML = '';

                data.forEach(session => {
                    let row = `
                        <tr>
                            <td>${session.id}</td>
                            <td>${session.user_id}</td>
                            <td>${session.trainer_name}</td>
                            <td>${session.session_date}</td>
                            <td>${session.session_time}</td>
                            <td>${session.location}</td>
                            <td>
                                <button class="edit-btn" onclick="editSession(${session.id})">Edit</button>
                                <button class="delete-btn" onclick="deleteSession(${session.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                sessionTableBody.innerHTML += row;
                });
            });
    }

    // Handle Edit Session
    function handleEditSession(event) {
        const sessionId = event.target.getAttribute('data-id');
        fetch(`get_session.php?id=${sessionId}`)
            .then(response => response.json())
            .then(session => {
                showSessionFormModal('Edit Session', session);
            })
            .catch(error => {
                console.error('Error fetching session:', error);
                alert('Failed to fetch session details.');
            });
    }

    // Handle Delete Session
    function handleDeleteSession(event) {
        const sessionId = event.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this session?')) {
            fetch(`delete_session.php?id=${sessionId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        displaySessions();
                    } else {
                        alert('Failed to delete session.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting session:', error);
                    alert('Failed to delete session.');
                });
        }
    }

    document.getElementById('addSessionBtn').addEventListener('click', function() {
        showSessionFormModal('Add New Session');
    });

    function showSessionFormModal(title, session = {}) {
        const modal = document.getElementById('sessionFormModal');
        const formTitle = document.getElementById('formTitle');
        const sessionForm = document.getElementById('sessionForm');

        formTitle.textContent = title;

        sessionForm.title.value = session.title || '';
        sessionForm.location.value = session.location || '';
        sessionForm.date.value = session.date || '';
        sessionForm.time.value = session.time || '';
        sessionForm.availability.value = session.availability || '';

        modal.style.display = 'block';

        sessionForm.onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData(sessionForm);
            const url = title === 'Add New Session' ? 'add_session.php' : `update_session.php?id=${session.id}`;
            const method = title === 'Add New Session' ? 'POST' : 'PUT';

            fetch(url, {
                method: method,
                body: formData,
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        displaySessions();
                        modal.style.display = 'none';
                    } else {
                        alert('Failed to save session.');
                    }
                })
                .catch(error => {
                    console.error('Error saving session:', error);
                    alert('Failed to save session.');
                });
        };
    }

    displaySessions();
}

// Initialize Book Sessions functionality
function initializeBookSessions() {
    const sessionList = document.getElementById('sessionList');
    const filterDate = document.getElementById('filterDate');
    const filterTime = document.getElementById('filterTime');
    const filterLocation = document.getElementById('filterLocation');

    // Fetch and display sessions
    function fetchAndDisplaySessions() {
        fetch('fetch_sessions.php')
            .then(response => response.json())
            .then(sessions => {
                sessionList.innerHTML = '';
                sessions.forEach(session => {
                    const listItem = document.createElement('li');
                    listItem.className = 'session-item';
                    listItem.innerHTML = `
                        <h3>${session.title}</h3>
                        <p>${session.date} at ${session.time}</p>
                        <p>Location: ${session.location}</p>
                        <p>Availability: ${session.availability}</p>
                        <button class="btn book-session" data-id="${session.id}">Book Now</button>
                    `;
                    sessionList.appendChild(listItem);
                });

                document.querySelectorAll('.book-session').forEach(button => {
                    button.addEventListener('click', handleBookSession);
                });
            })
            .catch(error => {
                console.error('Error fetching sessions:', error);
                alert('Failed to fetch sessions.');
            });
    }

    // Filter sessions based on selected criteria
    function filterSessions() {
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;
        const location = document.getElementById('location').value;
    
        // Fetch trainers from backend based on the filter criteria
        fetch(`findTrainers.php?date=${date}&time=${time}&location=${location}`)
            .then(response => response.json())
            .then(trainers => {
                const trainerContainer = document.getElementById('trainerContainer');
                trainerContainer.innerHTML = ''; // Clear previous trainers
    
                trainers.forEach(trainer => {
                    const trainerBox = document.createElement('div');
                    trainerBox.classList.add('trainer-box');
    
                    const trainerImage = document.createElement('img');
                    trainerImage.src = trainer.image;
                    trainerImage.alt = `Trainer ${trainer.name}`;
                    trainerBox.appendChild(trainerImage);
    
                    const trainerName = document.createElement('h3');
                    trainerName.textContent = trainer.name;
                    trainerBox.appendChild(trainerName);
    
                    const trainerBio = document.createElement('p');
                    trainerBio.textContent = trainer.bio;
                    trainerBox.appendChild(trainerBio);
    
                    trainerBox.addEventListener('click', function () {
                        selectTrainer(trainer, date, time, location);
                    });
    
                    trainerContainer.appendChild(trainerBox);
                });
            })
            .catch(error => console.error('Error fetching trainers:', error));
    }
    
    function selectTrainer(trainer) {
        document.getElementById('selectedTrainer').textContent = trainer.name;
        document.getElementById('selectedDate').textContent = trainer.date;
        document.getElementById('selectedTime').textContent = trainer.time;
        document.getElementById('selectedLocation').textContent = trainer.location;
    }
    
    function confirmBooking() {
        const selectedTrainer = document.getElementById('selectedTrainer').textContent;
        const selectedDate = document.getElementById('selectedDate').textContent;
        const selectedTime = document.getElementById('selectedTime').textContent;
        const selectedLocation = document.getElementById('selectedLocation').textContent;
    
        if (selectedTrainer && selectedDate && selectedTime && selectedLocation) {
            // Create a form and submit the data to the backend
            const formData = new FormData();
            formData.append('trainer', selectedTrainer);
            formData.append('date', selectedDate);
            formData.append('time', selectedTime);
            formData.append('location', selectedLocation);
    
            fetch('storeSession.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result);  // You can show a success message or redirect the user
            })
            .catch(error => {
                console.error('Error storing session:', error);
            });
        } else {
            alert('Please select a trainer and specify session details.');
        }
    }
    

    // Handle booking a session
    function handleBookSession(event) {
        const sessionId = event.target.getAttribute('data-id');
        const confirmation = confirm('Are you sure you want to book this session?');

        if (confirmation) {
            fetch(`book_session.php?id=${sessionId}`, { method: 'POST' })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Session booked successfully!');
                    } else {
                        alert('Failed to book session.');
                    }
                })
                .catch(error => {
                    console.error('Error booking session:', error);
                    alert('Failed to book session.');
                });
        }
    }

    filterDate.addEventListener('change', filterSessions);
    filterTime.addEventListener('change', filterSessions);
    filterLocation.addEventListener('input', filterSessions);

    fetchAndDisplaySessions();
}

//ensure ease in logging out
function initializeLogout() {
    const logoutLink = document.getElementById('logoutLink');

    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            console.log('Logout clicked');
            window.location.href = 'index.html';
        });
    }
}

//trainers notifications page
function displayNotifications() {
    const notificationsContainer = document.getElementById('notificationsContainer');
    const notifications = [
        { id: 1, type: 'Session Reminder', message: 'Your session with John Doe is scheduled for tomorrow at 10:00 AM.', important: false },
        { id: 2, type: 'New Booking Alert', message: 'Your session with Jane Smith is scheduled for tomorrow at 10:00 AM.', important: false },
        { id: 3, type: 'Important Update', message: 'Your session with John Doe is scheduled for tomorrow at 10:00 AM.', important: true }
    ];

    function displayNotificationsInner(notifications) {
        notificationsContainer.innerHTML = '';
        notifications.forEach(notification => {
            const notificationItem = document.createElement('div');
            notificationItem.className = 'notification-item';
            notificationItem.innerHTML = `
                <h3>${notification.type}</h3>
                <p class="${notification.important ? 'important' : ''}">${notification.message}</p>
        `;
        notificationsContainer.appendChild(notificationItem);
        });
    }

    displayNotificationsInner(notifications);
}

//trainers feedback and reviews
function displayFeedback() {
    const feedbackContainer = document.getElementById('feedbackContainer');
    const feedbacks = [
        { id: 1, surfer: 'Anita Wangui', comment: 'Great session! Learned a lot.', reply: ''},
        { id: 2, surfer: 'Jane Smith', comment: 'Enjoyed the training the trainer was patient and helpful.', reply: ''},
        { id: 3, surfer: 'Mike Makau', comment: 'Good experience but the water was a bit rough.', reply: ''}
    ];

    function displayFeedbackInner(feedbacks) {
        feedbackContainer.innerHTML = '';
        feedbacks.forEach(feedback => {
            const feedbackItem = document.createElement('div');
            feedbackItem.className = 'feedback-item';
            feedbackItem.innerHTML = `
                <h3>${feedback.surfer}</h3>
                <p>${feedback.comment}</p>
                <div class="reply-form">
                    <textarea placeholder="Write your reply..." data-id="${feedback.id}">${feedback.reply}</textarea>
                    <button data-id="${feedback.id}">Reply</button>
                </div>
            `;
            feedbackContainer.appendChild(feedbackItem);
        });

        document.querySelectorAll('.reply-form button').forEach(button => {
            button.addEventListener('click', handleReply);
        });
    }

    function handleReply(event) {
        const button = event.target;
        const feedbackId = button.getAttribute('data-id');
        const textarea = document.querySelector(`textarea[data-id="${feedbackId}"]`);
        const reply = textarea.value;

        const feedback = feedbacks.find(fb => fb.id == feedbackId);
        if (feedback) {
            feedback.reply = reply;
        }

        alert('Reply sent!');
    }

    displayFeedbackInner(feedbacks);
}

//trainer calendar
function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            { title: 'Session 1', start: '2024-07-10T10:00:00', end: '2024-07-10T11:00:00', description: 'Surfing session at Diani Beach'},
            { title: 'Session 2', start: '2024-07-15T14:00:00', end: '2024-07-15T15:00:00', description: 'Surfing session at Nyali Beach'},
            { title: 'Session 3', start: '2024-07-20T11:00:00', end: '2024-07-20T12:00:00', description: 'Surfing session at Watamu Beach'}
        ],
        headerToolbar: {
            left: 'prev, next today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, timeGridDay'
        },
        dateClick: function(info) {
            alert('Date: ' + info.dateStr);
        },
        eventClick: function(info) {
            alert('Event: ' + info.event.title + '\nDescription: ' + info.event.extendProps.description);
        }
    });

    calendar.render();
}

function hideWelcomeMessage() {
    const welcomeMessage = document.querySelector('.welcome-message');
    setTimeout(() => {
        welcomeMessage.style.transition = 'opacity 1s';
        welcomeMessage.style.opacity = '0';
        setTimeout(() => {
            welcomeMessage.style.display = 'none';
        }, 1000);
    }, 3000);
}

//home page slideshow
function initializeSlideshow() {
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName('mySlideshow');
        let dots = document.getElementsByClassName('dot');
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(' active', '');
        }
        slides[slideIndex - 1].style.display = 'block';
        dots[slideIndex - 1].className += ' active';
        setTimeout(showSlides, 3000); //changes images every 3 seconds
    }
}

function toggleForm() {
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');

    loginForm.classList.toggle('active');
    signupForm.classList.toggle('active');
}

//surfer weather page
function initializeWeather() {
    const apiKey = 'bac16d3afea327a55c39328a1ee2bd6b'; // Replace with your actual API key
    const locations = ['Mombasa', 'Nyali', 'Watamu', 'Malindi', 'Lamu', 'Diani', 'Kilifi', 'Manda', 'Bamburi', 'Shela'];

    // Fetch current weather data for each location
    locations.forEach(location => {
        fetchWeather(location);
        fetchForecast(location);
    });

    function fetchWeather(location) {
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${location}&appid=${apiKey}&units=metric`;

        fetch(url)
            .then(response => response.json())
            .then(data => displayWeather(data, location))
            .catch(error => console.error('Error fetching weather data:', error));
    }

    function displayWeather(data, location) {
        const weatherWidget = document.getElementById('weatherWidget');

        // Determine the weather icon based on the weather description
        const weatherDescription = data.weather[0].description;
        let weatherIcon;
        if (weatherDescription.includes('clear sky')) {
            weatherIcon = '☀️'; // Example icon for clear sky
        } else if (weatherDescription.includes('few clouds')) {
            weatherIcon = '🌤️'; // Example icon for few clouds
        } else if (weatherDescription.includes('scattered clouds')) {
            weatherIcon = '🌥️'; // Example icon for scattered clouds
        } else if (weatherDescription.includes('rain')) {
            weatherIcon = '🌧️'; // Example icon for rain
        } else {
            weatherIcon = '🌈'; // Default icon for other weather conditions
        }

        // Determine surf conditions based on wind speed
        const windSpeed = data.wind.speed;
        let surfConditions;
        if (windSpeed >= 1.4 && windSpeed <= 4.2) {
            surfConditions = 'Good';
        } else if (windSpeed > 4.2 && windSpeed <= 7.0) {
            surfConditions = 'Moderate';
        } else {
            surfConditions = 'Bad';
        }

        const weatherCard = `
            <div class="weather-card">
                <h2>${location}</h2>
                <p class="weather-description">${weatherIcon} ${data.weather[0].description}</p>
                <p class="temperature">Temperature: ${data.main.temp}°C</p>
                <p class="wind-speed">Wind Speed: ${data.wind.speed} m/s</p>
                <p class="surf-conditions">Surf Conditions: ${surfConditions}</p>
            </div>
        `;
        weatherWidget.innerHTML += weatherCard;
    }

    function fetchForecast(location) {
        const url = `https://api.openweathermap.org/data/2.5/forecast?q=${location}&appid=${apiKey}&units=metric`;

        fetch(url)
            .then(response => response.json())
            .then(data => displayForecast(data, location))
            .catch(error => console.error('Error fetching forecast data:', error));
    }

    function displayForecast(data, location) {
        const forecastContainer = document.getElementById('forecast');

        const forecastCard = `
            <div class="forecast-card">
                <h2>${location}</h2>
                <div class="forecast-details">
                    ${data.list.slice(0, 5).map(item => {
                    // Determine surf conditions based on wind speed
                    const windSpeed = item.wind.speed;
                    let surfConditions;
                    if (windSpeed >= 1.4 && windSpeed <= 4.2) {
                        surfConditions = 'Good';
                    } else if (windSpeed > 4.2 && windSpeed <= 7.0) {
                        surfConditions = 'Moderate';
                    } else {
                        surfConditions = 'Bad';
                    }
                    
                    return `
                        <div class="forecast-item">
                            <p>Date: ${item.dt_txt}</p>
                            <p>Temperature: ${item.main.temp}°C</p>
                            <p>Wind Speed: ${item.wind.speed} m/s</p>
                            <p>Surf Conditions: ${surfConditions}</p>
                        </div>
                    `;
                    }).join('')}
                </div>
            </div>
        `;
        forecastContainer.innerHTML += forecastCard;
    }
}

// Call the function to initialize the weather and forecast data
initializeWeather();


// Booking functionality
function initializeBookNow() {
    // Handle "Book Now" buttons
    const bookNowButtons = document.querySelectorAll('.book-now');
    bookNowButtons.forEach(button => {
        button.addEventListener('click', handleBooking);
    });

    // Handle "Find your Trainer" buttons
    const findTrainerButtons = document.querySelectorAll('.find-trainer');
    findTrainerButtons.forEach(button => {
        button.addEventListener('click', handleFindTrainer);
    });

    // Handle search button in the search bar
    const searchButton = document.getElementById('searchButton');
    if (searchButton) {
        searchButton.addEventListener('click', handleSearch);
    }
    
    // Hiding the navbar links once logged in or signing up
    const currentPage = window.location.pathname.split("/").pop();
    if (currentPage === "login.html" || currentPage === "signup.html") {
        const navLinks = document.querySelector("header nav");
        navLinks.style.display = "none";
    } 
}

// Handle booking button click
function handleBooking() {
    fetch('confirm_login.php')
        .then(response => response.json())
        .then(data => {
            if (!data.isLoggedIn) {
                alert('You must be logged in to book a session.');
                window.location.href = 'login.html';
            } else {
                alert('Redirecting to booking page...');
                window.location.href = 'booking.html';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Handle "Find your Trainer" button click
function handleFindTrainer() {
    fetch('confirm_login.php')
        .then(response => response.json())
        .then(data => {
            if (!data.isLoggedIn) {
                alert('You must be logged in to find a trainer.');
                window.location.href = 'login.html';
            } else {
                alert('Redirecting to Find a Trainer page...');
                window.location.href = 'findtrainer2.php';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Handle search button click
function handleSearch() {
    const locationInput = document.getElementById('locationInput').value.trim();

    fetch('confirm_login.php')
        .then(response => response.json())
        .then(data => {
            if (!data.isLoggedIn) {
                alert('Please log in to search for a trainer by location.');
                window.location.href = 'login.html';
            } else {
                if (locationInput) {
                    alert('Redirecting to Find a Trainer page...');
                    window.location.href = `findtrainer.html?location=${encodeURIComponent(locationInput)}`;
                } else {
                    alert('Please enter a location to search.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Initialize the booking functionality on page load
initializeBookNow();


//registration form validation
function initializeRegistrationForm() {
    const registrationForm = document.getElementById('registrationForm');
    const nameInput = registrationForm.querySelector('input[name="fullname"]');
    const emailInput = registrationForm.querySelector('input[name="email"]');
    const phoneInput = registrationForm.querySelector('input[name="phone"]');
    const passwordInput = registrationForm.querySelector('input[name="password"]');
    const confirmPasswordInput = registrationForm.querySelector('input[name="confirm-password"]');

    registrationForm.addEventListener('submit', function(event) {
        let isValid = true;

        //Validate full name
        const nameRegex = /^[A-Za-z\s]+$/;
        if (!nameRegex.test(nameInput.value)) {
            isValid = false;
            alert('Full name should only contain letters and spaces.');
        }

        //validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            isValid = false;
            alert('Please enter a valid email address.');
        }

        // Validate Phone Number
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            isValid = false;
            alert('Phone number should not exceed 15 digits.');
        }

        // Validate Password
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-+])[A-Za-z\d@$!%*?&_\-+]{8,}$/;
        if (!passwordRegex.test(passwordInput.value)) {
            isValid = false;
            alert('Password should have at least 8 characters, including special characters, uppercase and lowercase characters.');
        }

        // Confirm Password
        if (passwordInput.value !== confirmPasswordInput.value) {
            isValid = false;
            alert('Passwords do not match.');
        }

        if (!isValid) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
}

//User management -> displays users in the table
function displayUsers(role = '') {
    const userTableBody = document.getElementById('userTableBody');
    console.log(userTableBody); // Check if this logs an element or null
    if (!userTableBody) {
        console.error('Element with id "userTableBody" not found.');
        return;
    }

    const url = role ? `http://localhost/labs/GreatWave/fetch_users.php?role=${role}` : 'http://localhost/labs/GreatWave/fetch_users.php';


    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(users => {
            userTableBody.innerHTML = '';
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.role ? user.role : 'N/A'}</td>
                    <td>
                        <button class="btn edit-user" data-id="${user.id}">Edit</button>
                        <button class="btn delete-user" data-id="${user.id}">Delete</button>
                    </td>
                `;
                userTableBody.appendChild(row);
            });

            document.querySelectorAll('.edit-user').forEach(button => {
                button.addEventListener('click', handleEditUser);
            });

            document.querySelectorAll('.delete-user').forEach(button => {
                button.addEventListener('click', handleDeleteUser)
            });
        })
        .catch(error => {
            console.error('Error fetching users:', error);
            alert('Failed to fetch users: ' + error.message);
        });
    }

    //deals with handle editing the users in the table 
    function handleEditUser(event) {
        const userId = event.target.getAttribute('data-id');
        fetch(`get_user.php?id=${userId}`) //fetch(`get_user.php?id=${userId}`)
            .then(response => response.json())
            .then(user => {
                showUserFormModal('Edit User', user);
            })
            .catch(error => {
                console.error('Error fetching user:', error);
                alert('Failed to fetch user details.')
            });
    }

    //handles deleting a user
    function handleDeleteUser(event) {
        const userId = event.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`delete_user.php?id=${userId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        displayUsers();
                    } else {
                        alert('Failed to delete user.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    alert('Failed to delete user.')
                });
        }
    }

    document.getElementById('addUserBtn').addEventListener('click', function() {
        showUserFormModal('Add New User');
    });

    function showUserFormModal(title, user = {}) {
        const modal = document.getElementById('userFormModal');
        const formTitle = document.getElementById('formTitle');
        const userForm = document.getElementById('userForm');

        formTitle.textContent = title;

        userForm.name.value = user.name || '';
        userForm.email.value = user.email || '';
        userForm.phone.value = user.phone || '';
        userForm.role.value = user.role || 'surfer';

        modal.style.display = 'block';

        userForm.onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData(userForm);
            if (title === 'Add New User') {
                fetch('add_user.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        modal.style.display = 'none';
                        displayUsers();
                    } else {
                        alert('Failed to add user.');
                    }
                })
                .catch(error => {
                    console.error('Error adding user:', error);
                    alert('Failed to add user.')
                });
            } else {
                formData.append('id', user.id);
                fetch('edit_user.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        modal.style.display = 'none';
                        displayUsers();
                    } else {
                        alert('Failed to edit user.');
                    }
                })
                .catch(error => {
                    console.error('Error editing user:', error);
                    alert('Failed to edit user.')
                });
            }
        };

        document.querySelector('.close-btn').onclick = function() {
            modal.style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }

    displayUsers();

//trainer management -> displays trainers
function displayTrainers() {
    const trainerTableBody = document.getElementById('trainerTableBody');

    fetch('get_trainers.php')
        .then(response => response.json())
        .then(trainers => {
            trainerTableBody.innerHTML = '';
            trainers.forEach(trainer => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${trainer.id}</td>
                    <td>${trainer.name}</td>
                    <td>${trainer.email}</td>
                    <td>${trainer.phone}</td>
                    <td>${trainer.role ? trainer.role : 'N/A'}</td>
                    <td>
                        <button class="btn edit-trainer" data-id="${trainer.id}">Edit</button>
                        <button class="btn delete-trainer" data-id="${trainer.id}">Delete</button>
                    </td>
                `;
                trainerTableBody.appendChild(row);
            });

            document.querySelectorAll('.edit-trainer').forEach(button => {
                button.addEventListener('click', handleEditTrainer);
            });

            document.querySelectorAll('.delete-trainer').forEach(button => {
                button.addEventListener('click', handleDeleteTrainer)
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleEditTrainer(event) {
    const trainerId = event.target.getAttribute('data-id');
    fetch(`get_trainer.php?id=${trainer.id}`)
        .then(response => response.json())
        .then(trainer => {
            showTrainerFormModal('Edit Trainer', trainer);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleDeleteTrainer(event) {
    const trainerId = event.target.getAttribute('data-id');
    if (confirm('Are you sure you want to delete this trainer?')) {
        fetch(`delete_trainer.php?id=${trainerId}`, {method: 'DELETE' })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    displayTrainers();
                } else {
                    alert('Failed to delete trainer.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

document.getElementById('addTrainerBtn').addEventListener('click', function() {
    showTrainerFormModal('Add New Trainer');
});

function showTrainerFormModal(title, trainer = {}) {
    const modal = document.getElementById('trainerFormModal');
    const formTitle = document.getElementById('formTitle');
    const trainerForm = document.getElementById('trainerForm');

    formTitle.textContent = title;

    trainerForm.name.value = trainer.name || '';
    trainerForm.email.value = trainer.email || '';
    trainerForm.phone.value = trainer.phone || '';
    trainerForm.role.value = trainer.role || 'trainer';

    modal.style.display = 'block';

    trainerForm.onsubmit = function(event) {
        event.preventDefault();
        const formData = new FormData(trainerForm);
        if (title === 'Add New Trainer') {
            fetch('add_trainer.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    modal.style.display = 'none';
                    displayTrainers();
                } else {
                    alert('Failed to add trainer.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            formData.append('id', trainer.id);
            fetch('edit_trainer.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    modal.style.display = 'none';
                    displayTrainers();
                } else {
                    alert('Failed to edit trainer.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    };

    document.querySelector('.close-btn').onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
}




