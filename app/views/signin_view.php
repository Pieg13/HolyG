<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

    <h1>Sign In</h1>

    <form action="?action=signin" method="POST">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Sign In</button>

        <p>Don't have an account? <a href="?action=signup">Sign up</a></p>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>