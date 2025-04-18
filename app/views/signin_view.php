<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

    <h1 class="main-title">Sign In</h1>

    <form action="?action=signin" method="POST" class="basic-form">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email@company.com" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="button">Sign In</button>

        <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<p class="error-p">' . $error . "</p>";
                }
            }
        ?>

        <p>Don't have an account? <a href="?action=signup">Sign up</a></p>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>