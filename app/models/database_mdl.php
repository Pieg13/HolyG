<?php

/*
 * Establishes a PDO connection to the MySQL database using predefined constants.
 * Returns a PDO database connection object on success.
 * Throws exception if connection fails.
 */
function connect(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';charset=utf8mb4';
    
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
            return $pdo;
        } catch (PDOException $e) {
            $error='Database connection failed: ' . $e->getMessage();
            require VIEW_DIR . '/error_view.php';
            exit();
        }
    }
    return $pdo;
    
}

/*
 * Executes a parameterized database query securely
 * Parameters: SQL query and associative array of parameters
 * Returns the executed statement
 */
function executeQuery(string $sql, array $params = []): PDOStatement {
    $pdo = connect();
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params); // PDO handles binding internally
        return $stmt;
    } catch (PDOException $e) {
        die('Database operation failed: ' . $e->getMessage());
    }
}