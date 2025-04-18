<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<div>
    <h1 class="main-title">My Account</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
    <a href="logout" class="button">Log Out</a>
</div>

<?php require APP_DIR . '/views/footer_view.php'; ?>