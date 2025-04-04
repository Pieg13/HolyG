<?php

namespace App\Models\Database;

use PDO;
use PDOException;

abstract class DatabaseConnection {
    protected static function connect(): PDO {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE;
            return new PDO(
                $dsn,
                DB_USERNAME,
                DB_PASSWORD,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new DatabaseConnectionException(
                "Database unavailable. Please try again later.",
                500,
                $e
            );
        }
    }
}