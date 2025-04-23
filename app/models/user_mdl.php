<?php
require_once APP_DIR . '/models/database_mdl.php';

/* -------------------------------------------------------------------------- */
/*                                 USER MODEL                                 */
/* -------------------------------------------------------------------------- */

/* -------------- Handles all user-related database operations -------------- */

/**
 * Checks if email or username already exists
 * 
 * This function checks whether the provided email or username already exists in the database.
 * It performs two separate subqueries to check each one and returns an associative array indicating 
 * whether the email or username is already taken.
 * 
 * @param string $email Email to check
 * @param string $username Username to check
 * @return array ['email_exists' => bool, 'username_exists' => bool]
 * 
 * Security Insights:
 * - **Prepared Statements:** The function uses **prepared statements** to safely query the database, 
 *   preventing **SQL injection** by binding parameters (`:email` and `:username`).
 * - **No Direct User Input in Query:** User input is passed via prepared statements, not directly in SQL, 
 *   ensuring that inputs are safely handled as parameters.
 */
function checkExistingCredentials(string $email, string $username): array {
    $sql = "SELECT 
        EXISTS(SELECT 1 FROM User WHERE Email = :email) AS email_exists,
        EXISTS(SELECT 1 FROM User WHERE Username = :username) AS username_exists";
    
    $stmt = executeQuery($sql, [':email' => $email, ':username' => $username]);
    $result = $stmt->fetch();
    
    return [
        'email_exists' => (bool)$result['email_exists'],
        'username_exists' => (bool)$result['username_exists']
    ];
}



/**
 * Creates a new user account
 * 
 * This function validates the provided email, username, and password. The email is validated using PHP's
 * built-in `filter_var` function, and the username is checked against a regular expression to ensure it's 
 * alphanumeric and within the valid length range. The password is hashed using `password_hash` before being 
 * stored in the database to ensure secure storage.
 * 
 * @param string $email User's email
 * @param string $username User's username
 * @param string $password User's password
 * @return int ID of the newly created user
 * @throws InvalidArgumentException On validation failure
 * 
 * Security Insights:
 * - **Email Validation:** Uses **filter_var** with `FILTER_VALIDATE_EMAIL` to ensure the provided email is valid, 
 *   preventing malformed email addresses that could lead to issues or malicious inputs.
 * - **Username Validation:** Uses **regular expressions** to enforce that the username is alphanumeric and within 
 *   a valid length range (3-30 characters). This prevents malicious or special characters that could exploit the system.
 * - **Password Hashing:** **Password hashing** is performed using `password_hash()` to store passwords securely. 
 *   Even if the database is compromised, the passwords will not be stored in plaintext.
 * - **Prepared Statements:** Again, **prepared statements** are used to safely insert user data into the database, 
 *   preventing **SQL injection** attacks.
 */
function createUser(string $email, string $username, string $password): int {
    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Invalid email format");
    }
    
    // Validate the username (alphanumeric and between 3-30 characters)
    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        throw new InvalidArgumentException("Username must be 3-30 alphanumeric chars");
    }
    
    // Validate the password (at least 6 characters long)
    if (strlen($password) < 6) {
        throw new InvalidArgumentException("Password must have at least 6 characters");
    }

    // Hash the password before storing it in the database
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert a new user
    $sql = "INSERT INTO User (Email, Username, Password, Role)
            VALUES (:email, :username, :password, 'User')";
    
    executeQuery($sql, [
        ':email' => $email,
        ':username' => $username,
        ':password' => $password_hash
    ]);
    
    // Return the ID of the newly created user
    return (int)connect()->lastInsertId();
}

/**
 * Retrieves a user by email
 * 
 * This function retrieves a user record based on the provided email. The query is executed securely using 
 * prepared statements, and the result is returned as an associative array or null if no user is found.
 * 
 * @param string $email Email to search for
 * @return array|null User record or null if not found
 * 
 * Security Insights:
 * - **Input Sanitization:** The provided email is passed as a parameter to the prepared statement, 
 *   ensuring that any special characters in the email are safely handled.
 * - **Prepared Statements:** This function uses a **prepared statement** to prevent SQL injection.
 */
function getUserByEmail(string $email): ?array {
    $sql = "SELECT * FROM User WHERE Email = :email LIMIT 1";
    $stmt = executeQuery($sql, [':email' => $email]);
    return $stmt->fetch() ?: null;
}



/**
 * Deletes a user by ID
 * 
 * This function deletes a user record from the database using their user ID. It executes the deletion 
 * via a prepared statement to ensure the query is safe from SQL injection attacks.
 * 
 * @param int $userId ID of the user to delete
 * @return bool Always returns true
 * 
 * Security Insights:
 * - **Input Validation:** The user ID is cast to an integer to ensure that it is numeric, preventing potential 
 *   manipulation of the query (e.g., injecting strings or malicious data).
 * - **Prepared Statements:** Uses **prepared statements** to execute the query, ensuring safe handling of user inputs.
 */
function deleteUser(int $userId): bool {
    $sql = "DELETE FROM User WHERE UserID = :id";
    executeQuery($sql, [':id' => $userId]);
    return true;
}

/**
 * Retrieves all users
 * 
 * This function retrieves a list of all users from the database, returning user information such as ID, 
 * username, email, and role. The query is executed securely using prepared statements.
 * 
 * @return array Array of user records
 * 
 * Security Insights:
 * - **Prepared Statements:** The query uses **prepared statements** to ensure that any potential manipulation 
 *   of the query is prevented. Even though there are no user inputs in this case, it's a good practice to always use 
 *   prepared statements for database queries.
 */
function getAllUsers(): array {
    $sql = "SELECT UserID, Username, Email, Role FROM User ORDER BY UserID DESC";
    $stmt = executeQuery($sql);
    return $stmt->fetchAll();
}