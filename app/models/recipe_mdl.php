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
 * Retrieves all recipes with author information
 * @return array Array of recipe records
 */
function getAllRecipes(): array {
    $sql = "SELECT r.*, u.Username AS Author 
            FROM Recipe r
            JOIN User u ON r.CreatedBy = u.UserID
            ORDER BY r.RecipeID DESC";
    $stmt = executeQuery($sql);
    return $stmt->fetchAll();
}

/**
 * Deletes a recipe by ID
 * @param int $recipeId ID of the recipe to delete
 * @return bool Always returns true
 */
function deleteRecipe(int $recipeId): bool {
    $sql = "DELETE FROM Recipe WHERE RecipeID = :id";
    executeQuery($sql, [':id' => $recipeId]);
    return true;
}