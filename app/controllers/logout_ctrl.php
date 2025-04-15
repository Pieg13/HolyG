<?php

// Delete session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to home page
header("Location: index.php?action=home");
exit();
?>