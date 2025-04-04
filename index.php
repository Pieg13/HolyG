<?php

// Set secure session cokies
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
]);

/* ------------------------- require necessary files ------------------------ */
require __DIR__ . "/app/config/config.php";
require APP_DIR . "/config/routing.php";

?>