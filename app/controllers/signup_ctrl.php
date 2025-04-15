<?php
$title = 'Sign Up | HolyG';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require APP_DIR . '/models/user_mdl.php';
    
    // Sanitize inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validation
    $valid = true;
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
        $valid = false;
    }
    
    if (strlen($username) < 3 || strlen($username) > 30) {
        $errors[] = "Username must be between 3-50 characters";
        $valid = false;
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
        $valid = false;
    }

    // Check existing credentials
    if ($valid) {
        $exists = checkExistingCredentials($email, $username);
        
        if ($exists['email_exists']) {
            $errors[] = "Email address already registered";
        }
        if ($exists['username_exists']) {
            $errors[] = "Username is already taken";
        }
        
        if (!empty($errors)) {
            $valid = false;
        }
    }

    // Create user if valid
    if ($valid) {
        try {
            createUser($email, $username, $password);
            header('Location: index.php?action=signin');
            exit();
        } catch (InvalidArgumentException $e) {
            $errors[] = htmlspecialchars($e->getMessage());
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $errors[] = "Registration failed. Please try again.";
        }
    }
}

require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/signup_view.php';