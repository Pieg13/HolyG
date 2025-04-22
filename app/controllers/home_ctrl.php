<?php
require_once APP_DIR . '/models/recipe_mdl.php';
$title = "Home page | HolyG";
$intro = "Featured Recipes";
$recipes = getAllRecipes("featured");
require APP_DIR . '/views/home_view.php';

?>