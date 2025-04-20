<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main aria-label="Sign In Section">
    <h1 aria-label="Page Title">Sign In</h1>

    <form action="signin" method="POST" class="basic-form" aria-label="Sign In Form">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email@company.com" required aria-label="Email Input">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required aria-label="Password Input">

        <button type="submit" class="button" aria-label="Sign In Button">Sign In</button>

        <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<p class="error-p" aria-label="Error Message">' . $error . "</p>";
                }
            }
        ?>

        <p aria-label="Signup Prompt">Don't have an account? 
            <a href="signup" aria-label="Sign Up Link">Sign up</a>
        </p>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>