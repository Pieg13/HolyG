<?php

/* -------------------------------------------------------------------------- */
/*                               GENERAL CONFIG                               */
/* -------------------------------------------------------------------------- */

/* --------------------------- Define directories --------------------------- */
define("ROOT", dirname(dirname(__DIR__)));
define("APP_DIR", ROOT . "/app");
define("CTRL_DIR", APP_DIR . "/controllers");
define("VIEW_DIR", APP_DIR . "/views");
define("DB_DIR", APP_DIR . "/models");
define("PUBLIC_DIR", ROOT . "/public");

/* ----------------- Define database connection credentials ----------------- */
const DB_USERNAME = 'root'; // username
const DB_PASSWORD = ''; // user password
const DB_DATABASE = 'holyg'; // database name
const DB_HOST = 'localhost'; // database host

/* ------------------------- Authentication helpers ------------------------- */
function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function current_user_role(): ?string {
    return $_SESSION['user']['role'] ?? null;
}

function is_admin(): bool {
    return is_logged_in() && current_user_role() === 'Admin';
}

function current_user_id(): ?int {
    return $_SESSION['user']['id'] ?? null;
}

function current_user_data(): ?array {
    return $_SESSION['user'] ?? null;
}

?>