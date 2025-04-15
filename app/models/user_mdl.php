<?php
require_once APP_DIR . '/models/database_mdl.php';

/**
 * User Model - Handles all user-related database operations
 */

/*
 * Checks if a user exists with the given email or username
 * Parameters: strings $email and $username
 * Returns array with booleans for email and username existence
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

/*
 * Creates a new user in the database
 * Parameters: strings $email, $username and $password
 * Returns the new user's ID as integer
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

/*
 * Gets user by email
 * Parameter: string $email
 * Returns user array or null if not found
 */
function getUserByEmail(string $email): ?array {
    $sql = "SELECT * FROM User WHERE Email = :email LIMIT 1";
    $stmt = executeQuery($sql, [':email' => $email]);
    return $stmt->fetch() ?: null;
}