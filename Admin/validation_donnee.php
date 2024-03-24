<?php

include_once('connection_bd.php'); // Inclut le fichier de connexion à la base de données.

function test_input($data) { // Fonction pour nettoyer les données d'entrée.

	$data = trim($data); // Supprime les espaces en début et fin de chaîne.
	$data = stripslashes($data); // Supprime les antislashs d'une chaîne.
	$data = htmlspecialchars($data); // Convertit les caractères spéciaux en entités HTML.
	return $data; // Retourne les données nettoyées.
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Vérifie si la méthode de requête est POST.

	$username = test_input($_POST["username"]); // Nettoie le nom d'utilisateur envoyé via POST.
	$password = test_input($_POST["password"]); // Nettoie le mot de passe envoyé via POST.
	$stmt = $conn->prepare("SELECT * FROM adminlogin"); // Prépare une requête SQL.
	$stmt->execute(); // Exécute la requête.
	$users = $stmt->fetchAll(); // Récupère tous les résultats de la requête.

	foreach($users as $user) { // Boucle à travers les utilisateurs récupérés.

		if(($user['username'] == $username) && ($user['password'] == $password)) { // Vérifie si le nom d'utilisateur et le mot de passe correspondent.
			header("location: adminpage.php"); // Redirige vers la page d'administration.
		}
		else { // Si les informations ne sont pas correctes.

			echo "<script language='javascript'>"; // Affiche un message d'erreur en javascript.
			echo "alert('WRONG INFORMATION')"; // Affiche une alerte.
			echo "</script>"; // Fin du script.
			die(); // Arrête l'exécution du script.
		}
	}
}

?>
