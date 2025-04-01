<?php

// Routing in base of what $_GET returns
if (isset($_GET["action"])) {
    switch($_GET["action"]) {
        case "signin":
        require APP_DIR . "/controllers/signin_ctrl.php";
        break;
        case "signup":
        require APP_DIR . "/controllers/signup_ctrl.php";
        break;
        default:
        require ROOT . "/controllers/404_ctrl.php";
        break;
        }
} else {
    require APP_DIR . '/controllers/home_ctrl.php';
}

?>