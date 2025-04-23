<?php

/* -------------------------------------------------------------------------- */
/*                            ADMIN PAGE CONTROLLER                           */
/* -------------------------------------------------------------------------- */

// Redirect to signin if user is not admin
if (!is_admin()) {
    header('Location: signin');
    exit();
}

/* ------------------------- Handle the edit action ------------------------- */

// Check if 'id' and 'edit' are set in the URL and 'edit' is equal to 'recipe'
if (isset($_GET['edit']) && $_GET['edit'] === 'recipe' && isset($_GET['id'])) {
    // Retrieve the recipe ID from the URL parameter and cast it to an integer
    $recipeId = (int) $_GET['id'];
    
    // Include the recipe model and fetches data for a given ID
    require_once APP_DIR . '/models/recipe_mdl.php';
    $recipe = getRecipeById($recipeId);

    // If the recipe does not exist, redirect to the admin page
    if (!$recipe) {
        header("Location: admin");
        exit;
    }

    // If recipes wasn't created by current user, redirect to admin
    if ($recipe['CreatedBy'] !== current_user_id()) {
        header("Location: admin");
        exit;
    }

    // If the request method is POST (i.e., the form is being submitted)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and retrieve the form data
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
        $instructions = filter_input(INPUT_POST, 'instructions', FILTER_SANITIZE_STRING);
        $cookingTime = filter_input(INPUT_POST, 'cooking_time', FILTER_VALIDATE_INT);
        $difficulty = filter_input(INPUT_POST, 'difficulty', FILTER_SANITIZE_STRING);
        $createdBy = current_user_id();
        $image = $_FILES['image'] ?? null; // Check if image was uploaded (optional)
    
        // Default to current image if no new one is uploaded
        $imagePath = $recipe['ImageURL'];
    
        // If a new image is uploaded, handle the file upload process
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            // Set up the directory and allowed file types for the image upload
            $uploadDir = ROOT . '/public/images/recipes/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB limit
    
            // Check if the uploaded image exceeds the size limit
            if ($image['size'] > $maxSize) {
                throw new InvalidArgumentException("Image size exceeds 2MB limit");
            }
    
            // Check the MIME type of the uploaded image
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($image['tmp_name']);
            if (!in_array($mime, $allowedTypes)) {
                throw new InvalidArgumentException("Only JPG, PNG, and GIF images are allowed");
            }
    
            // Generate a unique filename for the uploaded image
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $filename = uniqid('recipe_', true) . '.' . $extension;
            $targetPath = $uploadDir . $filename;
    
            // Move the uploaded file to the target directory
            if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
                throw new RuntimeException("Failed to upload image");
            }
    
            // Set the new image path
            $imagePath = 'images/recipes/' . $filename;
        }
    
        // Call the updateRecipe function to update the recipe with the new data
        updateRecipe($recipeId, $title, $description, $ingredients, $instructions, $cookingTime, $difficulty, $createdBy, $imagePath);
    
        // Redirect to the admin page after saving
        $_SESSION['success'] = "Recipe updated successfully!";
        header("Location: admin");
        exit;
    }

    // Load the edit recipe view
    $title = "Edit Recipe | HolyG";
    require APP_DIR . '/views/edit_recipe_view.php';
    exit;
}

/* ----------------------- Handle recipe creation form ---------------------- */

// Check if the request method is POST and if the 'action' field is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Include the recipe model
    require_once APP_DIR . '/models/recipe_mdl.php';
    
    // Check if the action is 'create_recipe'
    if ($_POST['action'] === 'create_recipe') {
        try {
            // Initialize a variable for image path (null if no image is uploaded)
            $imagePath = null;
            
            // Handle file upload if a recipe image is provided
            if (!empty($_FILES['recipe_image']['name'])) {
                $uploadDir = ROOT . '/public/images/recipes/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB
                
                // Check if the uploaded image exceeds the size limit
                if ($_FILES['recipe_image']['size'] > $maxSize) {
                    throw new InvalidArgumentException("Image size exceeds 2MB limit");
                }

                // Check the imge type matches allowed types
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($_FILES['recipe_image']['tmp_name']);
                if (!in_array($mime, $allowedTypes)) {
                    throw new InvalidArgumentException("Only JPG, PNG, and GIF images are allowed");
                }
                
                // Generate a unique filename for the uploaded image to avoid conflicts
                $extension = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('recipe_', true) . '.' . $extension;
                $targetPath = $uploadDir . $filename;
                
                // Attempt to move the uploaded image to the target directory
                if (!move_uploaded_file($_FILES['recipe_image']['tmp_name'], $targetPath)) {
                    throw new RuntimeException("Failed to upload image");
                }
                
                $imagePath = 'images/recipes/' . $filename;
            }

            // Prepare the recipe data to be inserted into the database
            $recipeData = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'ingredients' => $_POST['ingredients'],
                'instructions' => $_POST['instructions'],
                'cooking_time' => $_POST['cooking_time'],
                'difficulty' => $_POST['difficulty'],
                'created_by' => current_user_id(),
                'image_path' => $imagePath,
            ];

            // Call the function to create the recipe in the database
            createRecipe($recipeData);

            // Set a success/error message to be displayed
            $_SESSION['success'] = "Recipe published successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: admin');
        exit();
    }
}

/* ------------------------- Handle deletion actions ------------------------ */

// Check if the 'delete' parameter is set in the URL
if (isset($_GET['delete'])) {
    // Use a switch statement to handle different types of deletions
    // Based on get, requires a defined model and executes delete function.
    switch ($_GET['delete']) {
        case 'user':
            if (isset($_GET['id'])) {
                require_once APP_DIR . '/models/user_mdl.php';
                deleteUser((int)$_GET['id']);
                $_SESSION['success'] = "User deleted successfully";
            }
            break;
        case 'recipe':
            if (isset($_GET['id'])) {
                require_once APP_DIR . '/models/recipe_mdl.php';
                deleteRecipe((int)$_GET['id']);
                $_SESSION['success'] = "Recipe deleted successfully";
            }
            break;
    }
    header('Location: admin');
    exit();
}

// Fetch data for admin dashboard (users and recipes)
require_once APP_DIR . '/models/user_mdl.php';
require_once APP_DIR . '/models/recipe_mdl.php';

$users = getAllUsers();
$recipes = getAllRecipes();

$title = 'Admin Dashboard | HolyG';
$currentPage = 'admin';

require APP_DIR . '/views/admin_view.php';