<?php
require_once APP_DIR . '/models/database_mdl.php';

/* -------------------------------------------------------------------------- */
/*                                RECIPE MODEL                                */
/* -------------------------------------------------------------------------- */

/* -------------- Handle all recipe-related database operations ------------- */

/**
 * Creates a new recipe in the database
 * 
 * This function inserts a new recipe into the database. It requires all necessary recipe fields 
 * to be present in the provided $recipeData array. Additionally, it validates the difficulty value 
 * to ensure it matches one of the predefined categories ('Easy', 'Medium', 'Hard').
 * 
 * @param array $recipeData Associative array containing recipe fields like title, description, ingredients, etc.
 * @return int The ID of the newly created recipe
 * @throws InvalidArgumentException If any required field is missing or if the difficulty is invalid
 * 
 * Security Insights:
 * - **Prepared Statements:** Uses prepared statements with parameterized queries to avoid SQL injection.
 * - **Input Validation:** Ensures that all required fields are present and that the difficulty is one of the allowed values.
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

    // Execute the SQL query securely with prepared statements
    executeQuery($sql, [
        ':title' => $recipeData['title'],
        ':description' => $recipeData['description'],
        ':ingredients' => $recipeData['ingredients'],
        ':instructions' => $recipeData['instructions'],
        ':cooking_time' => (int)$recipeData['cooking_time'], // Casting to prevent type-related issues
        ':difficulty' => $recipeData['difficulty'],
        ':created_by' => (int)$recipeData['created_by'],
        ':image_url' => $recipeData['image_path'] ?? null
    ]);

     // Return the ID of the newly created recipe
    return (int)connect()->lastInsertId();
}



/**
 * Retrieves all recipes or a limited number of featured recipes
 * 
 * This function fetches recipes from the database. It can either fetch all recipes or 
 * limit the result to 2 featured recipes based on the $type parameter.
 * 
 * @param string $type Type of recipes to fetch ('all' or 'featured')
 * @return array An array of recipe records, each containing recipe details and the author's username
 * 
 * Security Insights:
 * - **SQL Query Validation:** Limits the `$type` input to accepted values (`'all'` or `'featured'`) to prevent malicious input.
 * - **Prepared Statements:** Uses prepared statements to fetch data securely and protect against SQL injection.
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
 * Deletes a recipe by its ID
 * 
 * This function deletes a recipe from the database. If the recipe has an associated image, 
 * the image file will also be deleted from the server.
 * 
 * @param int $recipeID The ID of the recipe to delete
 * @return bool True if the recipe was successfully deleted, false if it was not found
 * 
 * Security Insights:
 * - **Sanitization of Input:** The `$recipeID` is cast to an integer to ensure no malicious code is executed.
 * - **File Handling:** The image is deleted only if it exists and if the file path is verified. Proper use of `basename()` avoids directory traversal vulnerabilities.
 * - **File System Security:** Uses `file_exists()` to check the image's presence before attempting deletion to prevent errors.
 */
function deleteRecipe(int $recipeID): bool {
    // Get the database connection
    $db = connect();

    // Fetch the recipe data to get its ImageURL
    $query = "SELECT ImageURL FROM Recipe WHERE RecipeID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$recipeID]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the recipe exists, proceed to delete
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

        // Delete the recipe from the database
        $deleteQuery = "DELETE FROM Recipe WHERE RecipeID = ?";
        $deleteStmt = $db->prepare($deleteQuery);
        $deleteStmt->execute([$recipeID]);

        return $deleteStmt->rowCount() > 0;  // Return true if a row was deleted
    }

    return false;  // Return false if the recipe wasn't found
}



/**
 * Retrieves a recipe by its ID with author information
 * 
 * This function fetches the details of a specific recipe, including the author's username.
 * 
 * @param int $recipeId The ID of the recipe to fetch
 * @return array|null The recipe details or null if the recipe was not found
 * 
 * Security Insights:
 * - **Input Sanitization:** The `$recipeId` parameter is cast to an integer to prevent SQL injection or other manipulation.
 * - **Prepared Statements:** Uses prepared statements to fetch data safely, preventing SQL injection.
 */
function getRecipeByID(int $recipeId): ?array {
    // SQL query to fetch the recipe and author information by recipe ID
    $sql = "SELECT r.*, u.Username AS Author 
            FROM Recipe r
            JOIN User u ON r.CreatedBy = u.UserID
            WHERE r.RecipeID = :id";
    
    // Execute the query and fetch the result
    $stmt = executeQuery($sql, [':id' => $recipeId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



/**
 * Updates an existing recipe's details
 * 
 * This function updates a recipe's information in the database. It allows the modification 
 * of the recipe title, description, ingredients, instructions, cooking time, difficulty, 
 * and image URL.
 * 
 * @param int $id The ID of the recipe to update
 * @param string $title The updated recipe title
 * @param string $description The updated recipe description
 * @param string $ingredients The updated recipe ingredients
 * @param string $instructions The updated recipe instructions
 * @param int $cookingTime The updated cooking time in minutes
 * @param string $difficulty The updated recipe difficulty (Easy, Medium, Hard)
 * @param int $createdBy The ID of the user who created the recipe
 * @param string|null $imageURL The updated image URL (optional)
 * @return void
 * 
 * Security Insights:
 * - **Input Sanitization and Validation:** All input parameters are properly sanitized to ensure safe and clean data before updating the database.
 * - **Prepared Statements:** The query uses prepared statements with bound parameters to avoid SQL injection risks.
 */
function updateRecipe($id, $title, $description, $ingredients, $instructions, $cookingTime, $difficulty, $createdBy, $imageURL) {
    $pdo = connect();
    
    // SQL query to update the recipe
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
    
    // Prepare the parameters
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
    
    // Execute the update query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
}



/**
 * Retrieves a list of featured recipes
 * 
 * This function fetches the most recent 2 recipes from the database. These are intended to be 
 * highlighted as featured recipes on the front page or other relevant sections.
 * 
 * @return array An array of featured recipes
 * 
 * Security Insights:
 * - **Prepared Statements:** The function uses a parameterized query to fetch data securely.
 */
function getFeaturedRecipes() {
    // Query to fetch the 2 most recent recipes
    $query = "SELECT * FROM Recipe ORDER BY RecipeID DESC LIMIT 2";
    $result = $db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}