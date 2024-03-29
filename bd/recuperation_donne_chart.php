<?php
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    //            RECUPERE DONNE POUR CHARTJS              //
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "iot_bd";

    // Connexion à la base de données
    $con = mysqli_connect($hostname, $username, $password, $database);

    // Vérification de la connexion
    if (!$con) {
        die("Connection échouée : " . mysqli_connect_error());
    }

    // Requête pour afficher les valeurs à partir de la date limite
    $req = mysqli_query($con, "SELECT temperature, humidite, historique FROM mesure ");

    // Vérification de la réussite de la requête
    if (!$req) {
        die("Erreur dans la requête : " . mysqli_error($con));
    }

    // Initialisation des tableaux
    $temperature = [];
    $humidite = [];
    $historique = [];

    // Boucle pour mettre les données dans les tableaux
    while ($data = mysqli_fetch_assoc($req)) {
        $temperature[] = $data['temperature'];
        $humidite[] = $data["humidite"];
        $historique[] = $data["historique"];
    }

    // Fermer la connexion à la base de données
    mysqli_close($con);

    // Créer un tableau associatif avec les données
    $response = array(
        'temperature' => $temperature,
        'humidite' => $humidite,
        'historique' => $historique
    );

    // Renvoyer les données au format JSON
    echo json_encode($response);
?>
