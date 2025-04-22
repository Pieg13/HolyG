<?php
require_once APP_DIR . '/models/database_mdl.php';

/**
 * Recipe Model - Handles all recipe-related database operations
 */

/**
 * Creates a new recipe in the database
 * @param array $recipeData Associative array containing recipe fields
 * @return int ID of the newly created recipe
 * @throws InvalidArgumentException On validation failure
 */
function createRecipe(array $recipeData): int {
    $required = ['title', 'description', 'ingredients', 'instructions', 'cooking_time', 'difficulty', 'created_by'];
    foreach ($required as $field) {
        if (empty($recipeData[$field])) {
            throw new InvalidArgumentException("Missing required field: $field");
        }
    }

    $allowedDifficulties = ['Easy', 'Medium', 'Hard'];
    if (!in_array($recipeData['difficulty'], $allowedDifficulties)) {
        throw new InvalidArgumentException("Invalid difficulty value");
    }

    $sql = "INSERT INTO Recipe (Title, Description, Ingredients, Instructions, 
            CookingTime, Difficulty, CreatedBy, ImageURL)
            VALUES (:title, :description, :ingredients, :instructions, 
            :cooking_time, :difficulty, :created_by, :image_url)";

    executeQuery($sql, [
        ':title' => $recipeData['title'],
        ':description' => $recipeData['description'],
        ':ingredients' => $recipeData['ingredients'],
        ':instructions' => $recipeData['instructions'],
        ':cooking_time' => (int)$recipeData['cooking_time'],
        ':difficulty' => $recipeData['difficulty'],
        ':created_by' => (int)$recipeData['created_by'],
        ':image_url' => $recipeData['image_path'] ?? null
    ]);

    return (int)connect()->lastInsertId();
}

/**
 * Retrieves all recipes or 2 recipes if featured is true
 * @return array Array of recipe records
 */
function getAllRecipes(string $type = 'all'): array {
    // Validate the type parameter
    if (!in_array($type, ['all', 'featured'])) {
        $type = 'all'; // Default to 'all' if invalid
    }

    // Base SQL query
    $sql = "SELECT r.*, u.Username AS Author 
            FROM Recipe r
            JOIN User u ON r.CreatedBy = u.UserID
            ORDER BY r.RecipeID DESC";

    // Add LIMIT 2 for 'featured'
    if ($type === 'featured') {
        $sql .= " LIMIT 2";
    }

    // Execute the query
    $stmt = executeQuery($sql);
    return $stmt->fetchAll();
}

/**
 * Deletes a recipe by ID
 * @param int $recipeId ID of the recipe to delete
 * @return bool Returns false if recipe was not found, true if deleted
 */
function deleteRecipe(int $recipeID): bool {
    // Get the database connection
    $db = connect();  // Calling the connect function to get the PDO instance

    // Fetch the recipe data to get its ImageURL
    $query = "SELECT ImageURL FROM Recipe WHERE RecipeID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$recipeID]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) {
        // Check if the recipe has an associated image
        if ($recipe['ImageURL']) {
            // Define the correct path to the image
            $imagePath = PUBLIC_DIR . '/images/recipes/' . basename($recipe['ImageURL']);

            // Check if the image exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Delete the image file
            }
        }

        // Now delete the recipe from the database
        $deleteQuery = "DELETE FROM Recipe WHERE RecipeID = ?";
        $deleteStmt = $db->prepare($deleteQuery);
        $deleteStmt->execute([$recipeID]);

        return $deleteStmt->rowCount() > 0;  // Return true if a row was deleted
    }

    return false;  // Return false if the recipe wasn't found
}



/**
 * Retrieves a recipe by its ID with author information
 * @param int $recipeId The ID of the recipe to fetch
 * @return array The recipe details or null if not found
 */
function getRecipeByID(int $recipeId): ?array {
    $sql = "SELECT r.*, u.Username AS Author 
            FROM Recipe r
            JOIN User u ON r.CreatedBy = u.UserID
            WHERE r.RecipeID = :id";
    $stmt = executeQuery($sql, [':id' => $recipeId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateRecipe($id, $title, $description, $ingredients, $instructions, $cookingTime, $difficulty, $createdBy, $imageURL) {
    $pdo = connect();
    
    $query = "UPDATE Recipe SET 
        Title = :title, 
        Description = :description, 
        Ingredients = :ingredients, 
        Instructions = :instructions, 
        CookingTime = :cookingTime, 
        Difficulty = :difficulty, 
        CreatedBy = :createdBy, 
        ImageURL = :imageURL 
        WHERE RecipeID = :id";
    
    $stmt = $pdo->prepare($query);
    
    // Explicitly cast integer values
    $params = [
        ':id' => (int)$id,
        ':title' => $title,
        ':description' => $description,
        ':ingredients' => $ingredients,
        ':instructions' => $instructions,
        ':cookingTime' => (int)$cookingTime,
        ':difficulty' => $difficulty,
        ':createdBy' => (int)$createdBy,
        ':imageURL' => $imageURL
    ];
    
    $stmt->execute($params); // Bind all parameters at once
}

function getFeaturedRecipes() {
    $query = "SELECT * FROM Recipe ORDER BY RecipeID DESC LIMIT 2";
    $result = $db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC); // Return recipes as an associative array
}