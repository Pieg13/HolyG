<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main aria-label="Registration Section">
    <h1 aria-label="Page Title">Register</h1>

    <form action="signup" method="POST" class="basic-form" aria-label="Sign Up Form">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email@company.com" required aria-label="Email Input">

        <label for="username">Username: (3 to 30 characters)</label>
        <input type="text" id="username" name="username" required minlength="3" maxlength="30" aria-label="Username Input">

        <label for="password">Password: (6 characters minimum)</label>
        <input type="password" id="password" name="password" required minlength="6" aria-label="Password Input">

        <?php if (!empty($errors)): ?>
            <div class="error-box" aria-label="Error Messages">
                <?php foreach ($errors as $error): ?>
                    <p aria-label="Error Message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="button" aria-label="Sign Up Button">Sign Up</button>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>