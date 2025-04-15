<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
    <a href="index.php?action=logout" class="button">Log Out</a>
    <!-- Add admin-specific content here -->
</div>

<?php require APP_DIR . '/views/footer_view.php'; ?>