<?php

/* -------------------------------------------------------------------------- */
/*                                Global config                               */
/* -------------------------------------------------------------------------- */

/* --------------------------- define directories --------------------------- */
define("ROOT", dirname(dirname(__DIR__)));
define("APP_DIR", ROOT . "/app"); // Define app directory
define("CTRL_DIR", APP_DIR . "/controllers"); // Define controllers directory
define("VIEW_DIR", APP_DIR . "/views"); // Define views directory
define("DB_DIR", APP_DIR . "/models"); // Define models directory
define("PUBLIC_DIR", ROOT . "/public"); // Define public directory

/* ----------------------- database connection related ---------------------- */
const DB_USERNAME = 'root'; // username
const DB_PASSWORD = ''; // user password
const DB_DATABASE = 'holyg'; // database name
const DB_HOST = 'localhost'; // database host

?>