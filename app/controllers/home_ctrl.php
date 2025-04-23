<?php

/* -------------------------------------------------------------------------- */
/*                            HOME PAGE CONTROLLER                            */
/* -------------------------------------------------------------------------- */

require_once APP_DIR . '/models/recipe_mdl.php';
$title = "Home page | HolyG";
$intro = "Featured Recipes"; // Changes recipe view's title
$recipes = getAllRecipes("featured"); // Get featured recipes
require APP_DIR . '/views/home_view.php';

?>