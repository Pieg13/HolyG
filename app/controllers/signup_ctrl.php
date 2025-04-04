<?php
use App\Models\UserModel;
use App\Exceptions\UserCreationException;

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Basic sanitization
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = $_POST['password'] ?? '';

        // Attempt registration
        $success = UserModel::create([
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        if ($success) {
            header("Location: ?action=signin");
            exit();
        }

    } catch (InvalidArgumentException $e) {
        $error = $e->getMessage();
    } catch (UserCreationException $e) {
        error_log("Signup error: " . $e->getMessage());
        $error = "Account creation failed. Please try different credentials.";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $error = "System temporarily unavailable. Please try later.";
    } catch (Throwable $e) {
        error_log("Unexpected error: " . $e->getMessage());
        $error = "An unexpected error occurred";
    }
}

$title = 'Sign Up | HolyG';
require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/signup_view.php';