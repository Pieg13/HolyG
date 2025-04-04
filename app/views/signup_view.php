<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

    <form action="index.php?action=signup" method="POST" enctype="multipart/form-data">
        <h2>Register</h2>

        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required minlength="3" maxlength="50">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6">

        <button type="submit">Sign Up</button>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>