<?php
require_once APP_DIR . '/models/user_mdl.php';

$title = 'Sign In | HolyG';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user'] = [
            'id' => $user['UserID'],
            'email' => $user['Email'],
            'username' => $user['Username'],
            'role' => $user['Role']
        ];

        // Redirect based on role
        if (is_admin()) {
            header('Location: index.php?action=admin');
        } else {
            header('Location: index.php?action=user');
        }
        exit();
    } else {
        $errors[] = 'Invalid email or password.';
    }
}

require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/signin_view.php';