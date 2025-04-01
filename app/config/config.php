<?php

/* -------------------------------------------------------------------------- */
/*                                Global config                               */
/* -------------------------------------------------------------------------- */

/* --------------------------- define root folder --------------------------- */
define("ROOT", dirname(dirname(__DIR__)));
define("APP_DIR", ROOT . "/app"); // Define app directory
define("PUBLIC_DIR", ROOT . "/public"); // Define public directory

/* ----------------------- database connection related ---------------------- */
const DB_USERNAME = 'root'; // username
const DB_PASSWORD = ''; // user password
const DB_DATABASE = 'holyg'; // database name
const DB_HOST = 'localhost'; // database host

?>