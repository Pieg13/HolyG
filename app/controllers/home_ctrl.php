<?php
require_once APP_DIR . '/models/recipe_mdl.php';
$title = "Home page | HolyG";
$recipes = getAllRecipes();
require APP_DIR . '/views/home_view.php';

?>