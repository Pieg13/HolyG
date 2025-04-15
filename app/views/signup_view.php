<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

    <h1 class="main-title">Register</h1>

    <form action="index.php?action=signup" method="POST" enctype="multipart/form-data" class="basic-form">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email@company.com" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="enter username here" required minlength="3" maxlength="50">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="enter password here" required minlength="6">

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <button type="submit">Sign Up</button>
    </form>

<?php require APP_DIR . '/views/footer_view.php'; ?>