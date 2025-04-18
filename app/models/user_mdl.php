<?php
require_once APP_DIR . '/models/database_mdl.php';

/**
 * User Model - Handles all user-related database operations
 */

/**
 * Checks if email or username already exists
 * @param string $email Email to check
 * @param string $username Username to check
 * @return array ['email_exists' => bool, 'username_exists' => bool]
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
 * @param string $email User's email
 * @param string $username User's username
 * @param string $password User's password
 * @return int ID of the newly created user
 * @throws InvalidArgumentException On validation failure
 */
function createUser(string $email, string $username, string $password): int {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Invalid email format");
    }
    
    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        throw new InvalidArgumentException("Username must be 3-30 alphanumeric chars");
    }
    
    if (strlen($password) < 6) {
        throw new InvalidArgumentException("Password must have at least 6 characters");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (Email, Username, Password, Role)
            VALUES (:email, :username, :password, 'User')";
    
    executeQuery($sql, [
        ':email' => $email,
        ':username' => $username,
        ':password' => $password_hash
    ]);
    
    return (int)connect()->lastInsertId();
}

/**
 * Retrieves a user by email
 * @param string $email Email to search for
 * @return array|null User record or null if not found
 */
function getUserByEmail(string $email): ?array {
    $sql = "SELECT * FROM User WHERE Email = :email LIMIT 1";
    $stmt = executeQuery($sql, [':email' => $email]);
    return $stmt->fetch() ?: null;
}


/**
 * Deletes a user by ID
 * @param int $userId ID of the user to delete
 * @return bool Always returns true
 */
function deleteUser(int $userId): bool {
    $sql = "DELETE FROM User WHERE UserID = :id";
    executeQuery($sql, [':id' => $userId]);
    return true;
}

/**
 * Retrieves all users
 * @return array Array of user records
 */
function getAllUsers(): array {
    $sql = "SELECT UserID, Username, Email, Role FROM User ORDER BY UserID DESC";
    $stmt = executeQuery($sql);
    return $stmt->fetchAll();
}