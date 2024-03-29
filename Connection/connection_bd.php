<?php

$conn = "";  

try {
	$servername = "localhost";  
	$dbname = "login";  
	$username = "root"; 
	$password = "";  

	// Crée une nouvelle instance de PDO pour établir la connexion à la base de données.
	$conn = new PDO(
		"mysql:host=$servername; dbname=login", // Chaîne de connexion PDO.
		$username, $password  
	);
	
	// Définit le mode de gestion des erreurs pour PDO.
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) { // Capture les exceptions PDO.

	echo "Connection failed: " . $e->getMessage(); 
}

?>
