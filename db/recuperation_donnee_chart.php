<?php
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//            RECUPERE DONNE POUR CHARTJS              //
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

include('./../interface/connection/connection_db.php');
$req = mysqli_query($conn, "SELECT temperature, humidite, historique FROM mesure ");

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
mysqli_close($conn);

// Créer un tableau associatif avec les données
$response = array(
    'temperature' => $temperature,
    'humidite' => $humidite,
    'historique' => $historique
);

// Renvoyer les données au format JSON
echo json_encode($response);
?>
