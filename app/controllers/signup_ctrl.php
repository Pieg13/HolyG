<?php

/* --------------------- Register new user into database -------------------- */

require APP_DIR . '/models/data_db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $profilePicture = $_FILES['profilePicture'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Ensure password length is valid
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle profile picture upload
    $profilePicturePath = NULL;
    if (!empty($profilePicture['name'])) {
        $targetDir = "public/assets/images/";
        $targetFile = $targetDir . basename($profilePicture["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }

        // Move the uploaded file
        if (empty($errors) && move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
            $profilePicturePath = $targetFile;
        } elseif (empty($errors)) {
            $errors[] = "Error uploading profile picture.";
        }
    }

    // If no errors, attempt to register the user
    if (empty($errors)) {
        $result = DBmain::registerUser($email, $username, $hashedPassword, $profilePicturePath);

        if ($result === true) {
            header("Location: index.php?page=signin");
            exit();
        } else {
            $errors[] = $result; // If the result is an error message
        }
    }
}

$title = 'Sign Up | HolyG';
require APP_DIR . '/views/signup_view.php';
?>