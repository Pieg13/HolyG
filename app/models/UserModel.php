<?php

namespace App\Models;

use PDO;
use PDOException;

class UserModel {
    
    /**
     * Creates a new user in the database.
     *
     * Parameter: array $userData with the user data (name, email, password, etc.)
     * Returns a boolean, true if the user was successfully created, otherwise false.
     */
    public static function create(array $userData): bool {
        // Validate required fields
        if (!isset($userData['email']) || !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Valid email is required.");
        }
        
        if (!isset($userData['password']) || !is_string($userData['password'])) {
            throw new \InvalidArgumentException("Password is required and must be a string.");
        }

        // Sanitize user input to prevent injections
        $userData['email'] = htmlspecialchars($userData['email']);
        $userData['password'] = htmlspecialchars($userData['password']);
        $userData['name'] = htmlspecialchars($userData['name']);

        // Check if email already exists in the database
        if (self::emailExists($userData['email'])) {
            throw new \InvalidArgumentException("Email is already taken.");
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

        // Prepare the SQL query to insert a new user into the database
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $userData['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $userData['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            
            return $stmt->execute(); // Execute the query
        } catch (PDOException $e) {
            // Log the error and provide a user-friendly message
            error_log("Failed to create user: " . $e->getMessage());
            throw new \RuntimeException("An error occurred while creating the user.");
        }
    }

    /**
     * Checks if the email already exists in the database.
     *
     * @param string $email The email address to check.
     * @return bool Returns true if the email already exists, otherwise false.
     */
    public static function emailExists(string $email): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            return $result > 0; // If the count is greater than 0, the email exists
        } catch (PDOException $e) {
            error_log("Failed to check email existence: " . $e->getMessage());
            throw new \RuntimeException("An error occurred while checking the email.");
        }
    }

    /**
     * Fetches a user by email.
     *
     * @param string $email The email of the user to fetch.
     * @return array The user data, or an empty array if not found.
     */
    public static function getUserByEmail(string $email): array {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data
        } catch (PDOException $e) {
            error_log("Failed to fetch user by email: " . $e->getMessage());
            throw new \RuntimeException("An error occurred while fetching the user.");
        }
    }

    /**
     * Verifies the user's password.
     *
     * @param string $password The password to verify.
     * @param string $hashedPassword The hashed password from the database.
     * @return bool Returns true if the password is correct, otherwise false.
     */
    public static function verifyPassword(string $password, string $hashedPassword): bool {
        return password_verify($password, $hashedPassword); // Verifies the password against the hash
    }
}