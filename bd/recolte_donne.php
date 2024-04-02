<?php
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    //             AJOUTE DES DONNES AU BD                 //
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////

    $hostname = "localhost"; // Adresse du serveur MySQL
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $database = "iot_bd"; // Nom de la base de données

    // Connexion à la base de données
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }
    echo "Connexion à la base de données réussie !";

    // Boucle pour générer des données simulées en continu

    // Génération de valeurs aléatoires pour la température et l'humidité
    $temperature =$_GET['temperature'];
    $humidite = $_GET['humidite'];

    // Commande SQL pour insérer les données simulées dans la table "mesure"
    $sql = "INSERT INTO mesure (temperature, humidite) VALUES ($temperature, $humidite)";

    // Exécution de la commande SQL
    if (mysqli_query($conn, $sql)) {
        //Nouvelle valeur enregistrée 
        echo "T= $temperature, H = $humidite<br>";
    } else {
        echo "Erreur lors de l'insertion des données : " . mysqli_error($conn);
    }



    // Fermeture de la connexion à la base de données (ce code ne sera jamais atteint dans une boucle infinie)
    mysqli_close($conn);

?>
