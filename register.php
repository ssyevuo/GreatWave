<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = $_POST['role'];

    // Confirm that passwords match
    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    // Handle file upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_pictures/';
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_path = $upload_dir . $file_name;

        // Ensure the directory exists
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        //Check if file is a valid image
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.history.back();</script>";
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
            $profile_picture = $file_path;
        } else {
            echo "<script>alert('Failed to upload profile picture.'); window.history.back();</script>";
            exit;
        }
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit;
        }
        $stmt->bind_param("sssss", $name, $email, $phone, $hashed_password, $role);
        $stmt->execute();

        // Get the ID of the newly created user
        $user_id = $conn->insert_id;

        // If the role is 'trainer', insert into trainers table
        if ($role === 'trainer') {
            $location = $_POST['location'];
            $bio = $_POST['bio'];

            $stmt = $conn->prepare("INSERT INTO trainers (user_id, name, email, phone, location, bio, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                exit;
            }
            $stmt->bind_param("issssss", $user_id, $name, $email, $phone, $location, $bio, $profile_picture);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Display success message and redirect to login page
        echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        exit;
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
