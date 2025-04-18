<?php
// Existing admin_ctrl.php content

// Redirect if not admin
if (!is_admin()) {
    header('Location: signin');
    exit();
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
                
                // Validate file
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
        header('Location: index.php?action=admin');
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
    header('Location: index.php?action=admin');
    exit();
}

require_once APP_DIR . '/models/user_mdl.php';
require_once APP_DIR . '/models/recipe_mdl.php';

$users = getAllUsers();
$recipes = getAllRecipes();

$title = 'Admin Dashboard | HolyG';
$currentPage = 'admin';

require APP_DIR . '/views/admin_view.php';