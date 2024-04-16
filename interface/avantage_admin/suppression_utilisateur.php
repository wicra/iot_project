<?php
/////////////////////////////////////////////////////////
//                        SESSION                     //
/////////////////////////////////////////////////////////

session_start();
// Verif si user connecter si la variable $_SESSION comptien le username 
if(!isset($_SESSION["username"])){
    header("location: ./connection/formulaire_connection.php");
exit(); 
}

// déconnection
if(isset($_POST['deconnection'])){
    session_destroy();
    header('location: ./connection/formulaire_connection.php');
}

include('./../connection/connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valeurASupprimer = htmlspecialchars(trim($_POST["username"]));
    $nomColonne = 'username';
    $tableName = 'identifiant';

    $sql = "DELETE FROM $tableName WHERE $nomColonne = '$valeurASupprimer'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // L'utilisateur a été supprimer avec succès
        header("location: ./../connection/formulaire_connection.php");
        exit();
    } else {
        // Une erreur s'est produite lors de l'ajout de l'utilisateur
        echo "Erreur : " . mysqli_error($conn);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Formulaire de suppression user</title>

		<!-- CSS FORMULAIRE DE CONNECTION CAR MEME DESIGN -->
		<link rel="stylesheet" href="./../styles/formulaire_connection.css">

		<!-- FONT -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

		<!-- ICON-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>

	<body>
		<form action="suppression_utilisateur.php" method="post">
			<div class="login-box">
				<h1>Suppression</h1>

				<div class="textbox">
					<i class="fa-solid fa-user"></i>
					<input type="text" placeholder="Nom d'utilisateur" name="username" value="">
				</div>

				<input class="button" type="submit" name="login" value="supprimer">

				<div class="lien-inscription">
					<a href="/iot_projet"><i class="fa-solid fa-circle-arrow-left"></i></a>					
					<a href="./../connection/formulaire_connection.php">tester l'existance</a>					
				</div>
			</div>
		</form>
	</body>
</html>