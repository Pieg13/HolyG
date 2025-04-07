<?php

namespace App\Models;

use PDO;
use PDOException;

class Database {
    /**
     * Establishes a PDO connection to the database using credentials from config.php.
     * Return PDO The PDO instance.
     */
    private static function connect(): PDO {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE;
            return new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("An error occurred. Please try again later.");
        }
    }

    /**
     * Fetch all records from a table with optional conditions.
     * Parameters:
     *      $table The table name.
     *      $conditions (optional) The conditions to filter results.
     * Returns array with the fetched results
     */
    public static function fetchAll(string $table, array $conditions = []): array {
        try {
            $pdo = self::connect();
            $sql = "SELECT * FROM $table";

            // Add conditions if provided
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $conditionStrings = [];
                foreach ($conditions as $key => $value) {
                    $conditionStrings[] = "$key = :$key";
                }
                $sql .= implode(" AND ", $conditionStrings);
            }

            $stmt = $pdo->prepare($sql);

            // Bind parameters to prevent SQL injection
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            die("An error occurred. Please try again later.");
        }
    }
}