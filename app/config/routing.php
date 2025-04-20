<?php

// Define routes as an associative array
$routes = [
    'home'              => CTRL_DIR . '/home_ctrl.php',
    'signin'            => CTRL_DIR . '/signin_ctrl.php',
    'signup'            => CTRL_DIR . '/signup_ctrl.php',
    'recipes'           => CTRL_DIR . '/recipes_ctrl.php',
    'recipe_details'    => CTRL_DIR . '/recipe_details_ctrl.php',
    'edit_recipe'       => CTRL_DIR . '/edit_recipe_ctrl.php',
    'about'             => CTRL_DIR . '/about_ctrl.php',
    'contact'           => CTRL_DIR . '/contact_ctrl.php',
    'logout'            => CTRL_DIR . '/logout_ctrl.php',
    'privacy'           => CTRL_DIR . '/privacy_ctrl.php',
    'admin'             => CTRL_DIR . '/admin_ctrl.php',
    'user'              => CTRL_DIR . '/user_ctrl.php',
];

// Set default page
$currentPage = 'home';

// Check if action parameter exists
if (isset($_GET["action"])) {
    // Make sure the action exists in our routes
    if (array_key_exists($_GET["action"], $routes)) {
        $currentPage = $_GET["action"];
    } else {
        // Invalid route - set to 404
        $currentPage = '404';
    }
}

// Make $currentPage available to all views
// Route handling using associative array
if ($currentPage === '404') {
    require CTRL_DIR . '/404_ctrl.php';
} else {
    require $routes[$currentPage];
}

?>