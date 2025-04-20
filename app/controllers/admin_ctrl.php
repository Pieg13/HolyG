<?php

// Redirect if not admin
if (!is_admin()) {
    header('Location: signin');
    exit();
}

// Handle the edit action
if (isset($_GET['edit']) && $_GET['edit'] === 'recipe' && isset($_GET['id'])) {
    $recipeId = (int) $_GET['id'];
    
    // Fetch the recipe data for the given ID
    require_once APP_DIR . '/models/recipe_mdl.php';
    $recipe = getRecipeById($recipeId);

    // If the recipe does not exist, redirect to the admin page
    if (!$recipe) {
        header("Location: admin");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $cookingTime = $_POST['cooking_time'];
        $difficulty = $_POST['difficulty'];
        $createdBy = current_user_id();  // Assuming the logged-in user is the one updating the recipe
        $image = $_FILES['image'] ?? null;
    
        // Handle file upload (for image change)
        $imagePath = $recipe['ImageURL'];  // Default to current image if no new one is uploaded
    
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            // Validate the uploaded file
            $uploadDir = ROOT . '/public/images/recipes/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB limit
    
            if ($image['size'] > $maxSize) {
                throw new InvalidArgumentException("Image size exceeds 2MB limit");
            }
    
            // Check the MIME type of the file
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($image['tmp_name']);
    
            if (!in_array($mime, $allowedTypes)) {
                throw new InvalidArgumentException("Only JPG, PNG, and GIF images are allowed");
            }
    
            // Generate a unique filename
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
    
        // Call the updateRecipe function to update the recipe in the database
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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once APP_DIR . '/models/recipe_mdl.php';
    
    if ($_POST['action'] === 'create_recipe') {
        try {
            $imagePath = null;
            
            // Handle file upload
            if (!empty($_FILES['recipe_image']['name'])) {
                $uploadDir = ROOT . '/public/images/recipes/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB
                
                if ($_FILES['recipe_image']['size'] > $maxSize) {
                    throw new InvalidArgumentException("Image size exceeds 2MB limit");
                }

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($_FILES['recipe_image']['tmp_name']);
                
                if (!in_array($mime, $allowedTypes)) {
                    throw new InvalidArgumentException("Only JPG, PNG, and GIF images are allowed");
                }
                
                // Generate unique filename
                $extension = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('recipe_', true) . '.' . $extension;
                $targetPath = $uploadDir . $filename;
                
                if (!move_uploaded_file($_FILES['recipe_image']['tmp_name'], $targetPath)) {
                    throw new RuntimeException("Failed to upload image");
                }
                
                $imagePath = 'images/recipes/' . $filename;
            }

            // Add new recipe to the database
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

            createRecipe($recipeData);
            $_SESSION['success'] = "Recipe published successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: admin');
        exit();
    }
}

// Handle deletion actions
if (isset($_GET['delete'])) {
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