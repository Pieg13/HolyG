<?php

// Define routes as an associative array
$routes = [
    'home'   => CTRL_DIR . '/home_ctrl.php',
    'signin' => CTRL_DIR . '/signin_ctrl.php',
    'signup' => CTRL_DIR . '/signup_ctrl.php',
];

// Set default page
$currentPage = 'home';

// Check if action parameter exists
if (isset($_GET["action"])) {
    $currentPage = $_GET["action"];
}

// Route handling using associative array
if (isset($routes[$currentPage])) {
    require $routes[$currentPage];
} else {
    // Handle 404 if route doesn't exist
    require CTRL_DIR . '/404_ctrl.php';
}

?>