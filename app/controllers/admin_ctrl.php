<?php

// Redirect if not admin
if (!is_admin()) {
    header('Location: index.php?action=signin');
    exit();
}

$title = 'Admin Dashboard | HolyG';
$currentPage = 'admin';

require APP_DIR . '/views/admin_view.php';