<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<h1 class="main-title">Contact us</h1>

<?php

if (isset($_SESSION["contact_status"])) {
    if ($_SESSION["contact_status"] === "success") {
        echo "<p style='color:green;'>Message sent successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error sending the message. Try again.</p>";
    }

    unset($_SESSION["contact_status"]);
}
?>

<form action="?action=contact" method="post" class="basic-form">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="email@company.com" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" required></textarea><br><br>

    <div class="checkbox-container">
        <input type="checkbox" id="privacy" name="privacy" required>
        <label for="privacy">
            I have read and agree to the <a href="?action=privacy" target="_blank">Privacy Policy</a>
        </label>
    </div>


    <input type="submit" value="Submit">
</form>

<?php require APP_DIR . '/views/footer_view.php'; ?>
