<?php

/* -------------------------------------------------------------------------- */
/*                           CONTACT PAGE CONTROLLER                          */
/* -------------------------------------------------------------------------- */

$title = "Contact | HolyG";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the form inputs to prevent XSS and injection attacks
    $name = trim($_POST["name"]);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = trim($_POST["message"]);

    // Email recipient parameters
    $to = "test@mail.com"; // Replace with actual email
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Send email
    if (mail($to, $subject, $body)) {
        $_SESSION["contact_status"] = "success";
    } else {
        $_SESSION["contact_status"] = "error";
    }

    // Redirect to the same page after processing to prevent form resubmission on refresh
    header("Location: contact");
    exit;
}

require APP_DIR . '/views/contact_view.php';