<?php

$title = "Contact | HolyG";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

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

    header("Location: contact");
    exit;
}

require APP_DIR . '/views/contact_view.php';