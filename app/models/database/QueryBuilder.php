<?php

namespace App\Models\Database;

use App\Models\Database\DatabaseConnection;
use PDO;
use PDOException;

class QueryBuilder {
    public static function fetchAll(string $table, array $conditions = []): array {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table)) {
            throw new \InvalidArgumentException("Invalid table name: $table");
        }
        try {
            $pdo = DatabaseConnection::connect();
            $sql = "SELECT * FROM $table";
            
            if (!empty($conditions)) {
                $where = array_map(fn($col) => "$col = :$col", array_keys($conditions));
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($conditions);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return [];
        }
    }
}

?>