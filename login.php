<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['id'];

        if (password_verify($password, $row["password"])) {       
            //session variables
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["userName"] = $row["name"];
            $_SESSION["role"] = $row["role"];


            //redirect based on the user's role
            if ($row["role"] == "surfer") {
                echo "<script>alert('Login Successful'); window.location.href = 'homepage.php';</script>";
            } elseif ($row["role"] == "trainer") {
                echo "<script>alert('Login Successful'); window.location.href = 'trainer_dashboard.php';</script>";
            } elseif ($row["role"] == "admin") {
                echo "<script>alert('Login Successful'); window.location.href = 'user-management.html';</script>";
            } else {
                echo "<script>alert('Login Successful'); window.location.href = 'homepage.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid Password'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email'); window.location.href = 'login.html';</script>";
    }

    $conn->close();
}

