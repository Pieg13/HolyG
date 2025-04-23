<?php

/* -------------------------------------------------------------------------- */
/*                        DATABASE CONNECTION AND QUERY                       */
/* -------------------------------------------------------------------------- */

/**
 * Establishes a PDO connection to the MySQL database using predefined constants.
 * Returns a PDO database connection object on success.
 * Throws exception if connection fails.
 * 
 * @return PDO The PDO connection object
 * 
 * Security Insights:
 * - **PDO (PHP Data Objects):** PDO is used for secure and flexible database access. It allows the use of **prepared statements**, which are essential in preventing **SQL injection** attacks.
 * - **Error Handling:** The function uses `try-catch` blocks to catch any **PDOExceptions**. If a connection fails, an error page is displayed to the user, preventing the exposure of sensitive database details.
 * - **Static Connection:** By using a static variable for `$pdo`, the connection is established only once, optimizing performance by reusing the connection for subsequent queries.
 */
function connect(): PDO {
    static $pdo = null;

    // Check if the PDO connection has already been established
    if ($pdo === null) {
        // Create the DSN (Data Source Name) string for connecting to the database
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';charset=utf8mb4';
    
        // Define PDO connection options
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exception handling for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch data as associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulated prepared statements
        ];

        try {
            // Create a new PDO instance and establish the connection
            $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
            return $pdo; // Return the established PDO connection
        } catch (PDOException $e) {
            $error='Database connection failed: ' . $e->getMessage();
            require VIEW_DIR . '/error_view.php'; // Redirect to an error page if connection fails
            exit();
        }
    }

    // Return the existing PDO connection if already established
    return $pdo;
    
}



/*
 * Executes a parameterized database query securely.
 * 
 * This function prepares and executes a database query using the provided SQL string and parameters.
 * It returns the executed PDO statement object.
 * 
 * @param string $sql The SQL query string to execute
 * @param array $params An associative array of parameters to bind to the query
 * @return PDOStatement The executed PDO statement object
 * 
 * Security Insights:
 * - **Prepared Statements:** This function ensures that queries are executed with **prepared statements**, which protects against **SQL injection** by separating SQL logic from user input.
 * - **Parameter Binding:** The parameters are bound to the query safely, and PDO automatically escapes any special characters in the input, preventing malicious SQL manipulation.
 * - **Error Handling:** A `try-catch` block catches any **PDOExceptions** that may arise during the execution of the query, ensuring the script doesn't reveal sensitive error details.
 * - **Separation of Data and Logic:** By using parameterized queries, the input data is **treated as data**, not executable SQL code, which is crucial for preventing SQL injection.
 */
function executeQuery(string $sql, array $params = []): PDOStatement {
    // Establish a PDO connection
    $pdo = connect();
    
    try {
        // Prepare the SQL query using the PDO connection
        $stmt = $pdo->prepare($sql);
        // Execute the query with the provided parameters, ensuring that they are safely bound
        $stmt->execute($params); // PDO handles parameter binding securely
        return $stmt; // Return the executed PDO statement object
    } catch (PDOException $e) {
        // Dies with an error message if an operation fails
        die('Database operation failed: ' . $e->getMessage());
    }
}