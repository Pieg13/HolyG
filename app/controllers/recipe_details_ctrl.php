<?php

require_once APP_DIR . '/models/recipe_mdl.php';

// Get the recipe ID from the URL and ensure it's an integer
$recipeID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the recipe details from the model if a valid recipe ID is provided
if ($recipeID) {
    // Query the database for the recipe using the validated ID
    $recipe = getRecipeByID($recipeID);

    if ($recipe) {
        // Pass the recipe data to the view with dynamic page title
        $title = htmlspecialchars($recipe['Title']) . " | HolyG";
        require APP_DIR . '/views/head_view.php';
        require APP_DIR . '/views/header_view.php';
        require APP_DIR . '/views/recipe_details_view.php';
        require APP_DIR . '/views/footer_view.php';
    } else {
        // If no recipe is found, show an error message
        $title = "Recipe Not Found | HolyG";
        require APP_DIR . '/views/error_view.php';
    }
} else {
    // If no recipe ID is provided, show an error message
    $title = "Invalid Recipe | HolyG";
    require APP_DIR . '/views/error_view.php';
}
?>