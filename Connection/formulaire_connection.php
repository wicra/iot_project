<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="formulaire_connection.css">
	<title>Page de connection</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
	<!-- ICON-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
	<form action="validation_donnee.php" method="post">
		<div class="login-box">
			<h1>Se connecter</h1>

			<div class="textbox">
				<i class="fa-solid fa-user"></i>
				    <!--  <i class="fa fa-user" aria-hidden="true"></i>-->
				<input type="text" placeholder="Nom d'utilisateur" name="username" value="">
			</div>

			<div class="textbox">
				
				<i class="fa-solid fa-lock"></i>
				<!-- <i class="fa fa-lock" aria-hidden="true"></i>-->
				<input type="password" placeholder="Mot de passe"
						name="password" value="">
			</div>

			<input class="button" type="submit"
					name="login" value="Connection">
		</div>
	</form>
</body>

</html>
