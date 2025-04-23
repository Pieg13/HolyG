<?php
require_once APP_DIR . '/models/user_mdl.php';

$title = 'Sign In | HolyG';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize email input to prevent invalid email addresses and potential XSS attacks
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Fetch user from the database by email
    $user = getUserByEmail($email);

    // Validate user credentials securely
    if ($user && password_verify($password, $user['Password'])) {
        // Store user session data securely
        $_SESSION['user'] = [
            'id' => $user['UserID'],
            'email' => $user['Email'],
            'username' => $user['Username'],
            'role' => $user['Role']
        ];

        // Redirect based on role
        if (is_admin()) {
            header('Location: admin');
        } else {
            header('Location: user');
        }
        exit();
    } else {
        // If authentication fails, adds an error message
        $errors[] = 'Invalid email or password.';
    }
}

require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/signin_view.php';