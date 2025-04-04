<?php

namespace App\Models;

use App\Models\Database\DatabaseConnection;
use App\Models\Database\QueryBuilder;
use PDO;
use PDOException;

class UserModel extends DatabaseConnection {
    // User-specific methods
    public static function create(array $userData): bool {
        try {
            // Validate required fields
            if (!isset($userData['password']) || !is_string($userData['password'])) {
                throw new \InvalidArgumentException("Password is required and must be a string");
            }
            
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("Invalid email format");
            }

            $pdo = parent::connect();
    
            if (self::exists($userData['email'], $userData['username'])) {
                throw new \Exception("Email or username already exists");
            }
    
            // Hash the password
            $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
            
            // Validate hash success
            if ($hashedPassword === false) {
                throw new \RuntimeException("Password hashing failed");
            }
    
            $role = $userData['role'] ?? 'User';
            $sql = "INSERT INTO User (Email, Username, Password, Role)
                    VALUES (:email, :username, :password, :role)";
            
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':email' => $userData['email'],
                ':username' => $userData['username'],
                ':password' => $hashedPassword,  // Store the hash
                ':role' => $role
            ]);
            
        } catch (PDOException $e) {
            error_log("User creation failed: " . $e->getMessage());
            throw new UserCreationException("Failed to create user", 0, $e);
        }
    }

    public static function findByEmail(string $email): ?array {
        try {
            $pdo = parent::connect();
            $stmt = $pdo->prepare("SELECT * FROM User WHERE Email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("User search failed: " . $e->getMessage());
            return null;
        }
    }

    private static function exists(string $email, string $username): bool {
        $pdo = parent::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM User 
                              WHERE Email = :email OR Username = :username");
        $stmt->execute([':email' => $email, ':username' => $username]);
        return $stmt->fetchColumn() > 0;
    }
}

?>