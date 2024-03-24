<?php

$conn = ""; // Initialise la variable de connexion à la base de données.

try {
	$servername = "localhost"; // Nom du serveur MySQL.
	$dbname = "geeksforgeeks"; // Nom de la base de données.
	$username = "root"; // Nom d'utilisateur MySQL.
	$password = ""; // Mot de passe MySQL.

	// Crée une nouvelle instance de PDO pour établir la connexion à la base de données.
	$conn = new PDO(
		"mysql:host=$servername; dbname=geeksforgeeks", // Chaîne de connexion PDO.
		$username, $password // Nom d'utilisateur et mot de passe.
	);
	
	// Définit le mode de gestion des erreurs pour PDO.
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) { // Capture les exceptions PDO.

	echo "Connection failed: " . $e->getMessage(); // Affiche un message d'erreur de connexion.
}

?>
