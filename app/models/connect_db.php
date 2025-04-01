<?php

/* -------------------------------------------------------------------------- */
/*                             Database Connection                            */
/* -------------------------------------------------------------------------- */

	abstract class DbConnect {
		
		/*
		 * Establishes connection to database using PDO
		 * Returns a PDO instance connected to database
		 */
		private static function connection() {
			try {
				$dsn = 'mysql:host=' . DB_HOST .';dbname=' . DB_DATABASE;
				$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $pdo;
			} catch (PDOException $e) {
				die("<br />PDO connection error !");
			}		
		}
		
		/*
		 * Executes a prepared SQL request
		 * Parameter: SQL query to be executed in form of a string
		 * Returns: the prepared and executed query object
		 */
		protected static function executeRequest($sql) {

			try {
				$query = self::connection()->prepare($sql);
				$query->execute();
				return $query;
			}
			catch(Exception $e) {
				die( $e->getMessage()."<br />Unable to fetch data from the table !" );
			} finally {
				$query = null;
			}
		}
		
	}