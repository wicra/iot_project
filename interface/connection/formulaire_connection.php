<?php

include('./connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	session_start();

	if (!isset($_SESSION['est_admin'])) {
		$_SESSION['count'] = 0;
	} else {
		$_SESSION['count']++;
	}

    $username = htmlspecialchars(trim($_POST["username"])); // Nettoie et récupère le nom d'utilisateur.
    $password = sha1(htmlspecialchars(trim($_POST["password"]))); // Nettoie et récupère le mot de pass cripté

	

    // Requête SQL pour vérifier l'utilisateur dans la table identifiant.
    $stmt = $conn->prepare("SELECT * FROM identifiant WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]); // Exécute la requête avec les paramètres.
    $user = $stmt->fetch(); // Récupère le premier résultat de la requête.

    if ($user) {
		$_SESSION['username'] = $username ;
		$_SESSION['password'] = $password ;
		
        // Redirige l'utilisateur en fonction de son statut d'administrateur.
        if ($user['est_admin']) {
            header("location: ./../admin/adminpage.php");
        } else {
            header("location: ./../user/userpage.php");
        }
        exit(); 
    } else {
        header("location: formulaire_connection.php");
        exit(); 
    };
}

?>




<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Formulaire de Connection</title>

		<!-- CSS -->
		<link rel="stylesheet" href="./../styles/formulaire_connection.css">

		<!-- FONT -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

		<!-- ICON-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>

	<body>
		<form action="formulaire_connection.php" method="post">
			<div class="login-box">
				<h1>Se connecter</h1>

				<div class="textbox">
					<i class="fa-solid fa-user"></i>
					<input type="text" placeholder="Nom d'utilisateur" name="username" value="">
				</div>

				<div class="textbox">
					<i class="fa-solid fa-lock"></i>
					<input type="password" placeholder="Mot de passe" name="password" value="">
				</div>

				<input class="button" type="submit" name="login" value="Connection">
			</div>
		</form>
	</body>
</html>
