<?php
use App\Models\UserModel;
use App\Exceptions\UserCreationException;

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Basic sanitization (still important for security)
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        // Attempt to find user
        $user = UserModel::findByEmail($email);

        // Verify credentials
        if ($user && password_verify($password, $user['Password'])) {
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Store user in session
            $_SESSION['user'] = [
                'id' => $user['UserID'],
                'email' => $user['Email'],
                'username' => $user['Username']
            ];

            // Redirect to home
            header("Location: ?action=home");
            exit();
        }

        // Generic error message for security
        $error = "Invalid credentials";

    } catch (PDOException $e) {
        error_log("Signin error: " . $e->getMessage());
        $error = "System error. Please try later.";
    } catch (Throwable $e) {
        error_log("Unexpected error: " . $e->getMessage());
        $error = "An unexpected error occurred";
    }
}

// Render view
$title = 'Sign In | HolyG';
require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/signin_view.php';