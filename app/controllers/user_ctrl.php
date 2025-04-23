<?php

/* -------------------------------------------------------------------------- */
/*                        USER PROFILE PAGE CONTROLLER                        */
/* -------------------------------------------------------------------------- */

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: signin');
    exit();
}

$title = 'My Account | HolyG';
$currentPage = 'user';

require APP_DIR . '/views/user_view.php';