<?php

	require APP_DIR . "/models/connect_db.php";

	class DBmain extends DbConnect {

		/*
		 * Fetches all content from a specified table
		 * Parameter: the name of the table to fetch data from
		 * Returns: an array of associative rows from the table
		 */
		public static function getTableContent($table) {

			$sql = "SELECT * FROM $table";
			$req = self::executeRequest($sql);
			// Fetches rows as an associative array
			$data = $req->fetchALL(PDO::FETCH_ASSOC);
			
			if(!empty($data)) {
				return $data;
			}
			return [];
			
		}

		public static function registerUser($email, $username, $hashedPassword, $profilePicture) {
			try {
				$pdo = self::connection();
		
				// Check if the email or username already exists
				$checkSql = "SELECT COUNT(*) FROM User WHERE Email = :email OR Username = :username";
				$checkStmt = $pdo->prepare($checkSql);
				$checkStmt->execute([
					':email' => $email,
					':username' => $username
				]);
				$count = $checkStmt->fetchColumn();
		
				if ($count > 0) {
					return "Email or username already exists.";
				}
		
				// Insert new user
				$sql = "INSERT INTO User (Email, Username, Password, Role, ProfilePicture) 
						VALUES (:email, :username, :password, 'User', :profilePicture)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([
					':email' => $email,
					':username' => $username,
					':password' => $hashedPassword,
					':profilePicture' => $profilePicture
				]);
		
				return true;
			} catch (Exception $e) {
				return "Database error: " . $e->getMessage();
			}
		}
	}

	/* ---------------------------------- TEST ---------------------------------- */

	// $allowedTables = [];
	// if (!in_array($table, $allowedTables)) {
	// 	die('Invalid table name provided!');
	// }
?>