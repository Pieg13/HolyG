<?php
require_once APP_DIR . '/models/recipe_mdl.php';

// Check if the user is an admin or the recipe owner
if (!is_admin() && !is_recipe_owner($_GET['id'])) { // Implement is_recipe_owner() logic
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    // Validate recipe ID
    $recipeId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$recipeId) {
        header("Location: admin");
        exit;
    }

    // Fetch the recipe
    $recipe = getRecipeByID($recipeId);
    if (!$recipe) {
        header("Location: admin");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize all inputs
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
        $instructions = filter_input(INPUT_POST, 'instructions', FILTER_SANITIZE_STRING);
        $cookingTime = filter_input(INPUT_POST, 'cooking_time', FILTER_VALIDATE_INT);
        $difficulty = filter_input(INPUT_POST, 'difficulty', FILTER_SANITIZE_STRING);
        $image = $_FILES['image'] ?? null;

        // Validate required fields
        $errors = [];
        if (empty($title)) $errors[] = "Title is required";
        if (empty($ingredients)) $errors[] = "Ingredients are required";
        if (empty($instructions)) $errors[] = "Instructions are required";
        if (!$cookingTime || $cookingTime < 1) $errors[] = "Invalid cooking time";
        
        $allowedDifficulties = ['Easy', 'Medium', 'Hard'];
        if (!in_array($difficulty, $allowedDifficulties)) $errors[] = "Invalid difficulty";

        // Handle file upload securely
        $imagePath = $recipe['ImageURL'];
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_DIR . '/images/recipes/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            // Validate upload
            if ($image['size'] > $maxSize) {
                $errors[] = "Image size exceeds 2MB limit";
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($image['tmp_name']);
            if (!in_array($mime, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, and GIF images are allowed";
            }

            if (empty($errors)) {
                // Generate safe filename
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filename = uniqid('recipe_', true) . '.' . $extension;
                $targetPath = $uploadDir . basename($filename);

                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $imagePath = 'images/recipes/' . $filename;
                    // Delete old image if it exists
                    if ($recipe['ImageURL']) {
                        $oldImage = PUBLIC_DIR . '/' . $recipe['ImageURL'];
                        if (file_exists($oldImage)) unlink($oldImage);
                    }
                } else {
                    $errors[] = "Failed to upload image";
                }
            }
        }

        if (empty($errors)) {
            try {
                updateRecipe(
                    $recipeId,
                    $title,
                    $description,
                    $ingredients,
                    $instructions,
                    $cookingTime,
                    $difficulty,
                    $recipe['CreatedBy'], // Preserve original author
                    $imagePath
                );
                $_SESSION['success'] = "Recipe updated successfully!";
                header("Location: admin");
                exit;
            } catch (Exception $e) {
                $errors[] = "Error updating recipe: " . $e->getMessage();
            }
        }

        // Store errors in session to display in view
        $_SESSION['form_errors'] = $errors;
    }

    // Load view with sanitized data
    $title = "Edit Recipe | HolyG";
    require APP_DIR . '/views/edit_recipe_view.php';
} else {
    header("Location: admin");
    exit;
}