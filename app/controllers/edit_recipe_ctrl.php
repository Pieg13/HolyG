<?php
require_once APP_DIR . '/models/recipe_mdl.php';

// Check if the user is an admin
if (!is_admin()) {
    header("Location: index.php");  // Redirect if not an admin
    exit;
}

if (isset($_GET['id'])) {
    $recipeId = (int) $_GET['id'];

    // Fetch the recipe from the database
    $recipe = getRecipeById($recipeId);

    // If the recipe does not exist, redirect to the admin page
    if (!$recipe) {
        header("Location: admin"); 
        exit;
    }

    // If the form is submitted, update the recipe
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $cookingTime = $_POST['cooking_time'];
        $difficulty = $_POST['difficulty'];
        $image = $_FILES['image'] ?? null;

        // Handle file upload
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '_' . $image['name'];
            $uploadPath = PUBLIC_DIR . '/images/recipes/' . $imageName;
            move_uploaded_file($image['tmp_name'], $uploadPath);
        } else {
            $imageName = $recipe['ImageURL'];  // Keep the old image if no new one is uploaded
        }

        // Update the recipe in the database
        updateRecipe($recipeId, $title, $author, $description, $cookingTime, $difficulty, $imageName);

        // Redirect to the admin page after saving
        header("Location: admin");
        exit;
    }

    // Load the edit recipe view
    require APP_DIR . '/views/edit_recipe_view.php';
} else {
    // If no recipe ID is provided, redirect to the admin page
    header("Location: admin");
    exit;
}