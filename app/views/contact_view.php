<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main aria-label="Contact Us Section">
    <h1 aria-label="Page Title">Contact Us</h1>

    <?php
    if (isset($_SESSION["contact_status"])) {
        if ($_SESSION["contact_status"] === "success") {
            echo "<p style='color:green;' aria-label='Success Message'>Message sent successfully!</p>";
        } else {
            echo "<p style='color:red;' aria-label='Error Message'>Error sending the message. Try again.</p>";
        }

        unset($_SESSION["contact_status"]);
    }
    ?>

    <div class="container" aria-label="Contact Form Container">
        <form action="contact" method="post" class="basic-form" aria-label="Contact Form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required aria-label="Name Input">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="email@company.com" required aria-label="Email Input">

            <label for="message">Message:</label>
            <textarea id="message" name="message" required aria-label="Message Input"></textarea>

            <div class="checkbox-container" aria-label="Privacy Policy Agreement">
                <input type="checkbox" id="privacy" name="privacy" required aria-label="Privacy Policy Checkbox">
                <label for="privacy">
                    I have read and agree to the <a href="privacy" target="_blank" aria-label="Privacy Policy Link">Privacy Policy</a>
                </label>
            </div>

            <input type="submit" value="Submit" class="button" aria-label="Submit Button">
        </form>
    </div>
</main>

<?php require APP_DIR . '/views/footer_view.php'; ?>