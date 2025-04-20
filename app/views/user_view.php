<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main aria-label="User Account Section">
    <div aria-label="Account Information">
        <h1 aria-label="Page Title">My Account</h1>
        <p aria-label="User Greeting">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
        <a href="logout" class="button" aria-label="Logout Button">Log Out</a>
    </div>

<?php require APP_DIR . '/views/footer_view.php'; ?>