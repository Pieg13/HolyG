<?php
require_once APP_DIR . '/models/recipe_mdl.php';

$title = "Recipes | HolyG";
$recipes = getAllRecipes();

require APP_DIR . '/views/head_view.php';
require APP_DIR . '/views/header_view.php';

require APP_DIR . '/views/recipes_view.php';

require APP_DIR . '/views/footer_view.php';