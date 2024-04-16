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
	$sql = "SELECT * FROM identifiant WHERE username = '$username' AND password = '$password'";
	$result  = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
		$user = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $username ;
		$_SESSION['password'] = $password ;
		
		header("location: ./../interface.php");
        exit(); 
    } else {
        header("location: formulaire_connection.php");
        exit(); 
    };
}
?>
<!DOCTYPE html>
<html lang="fr">
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

				<div class="lien-inscription">
					<a href="./../../index.php"><i class="fa-solid fa-circle-arrow-left"></i></a>					
					<a href="formulaire_inscription.php">crée un compte</a>					
				</div>
			</div>
		</form>
	</body>
</html>
