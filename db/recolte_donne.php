<?php
/////////////////////////////////////////////////////////
//       AJOUTE DES DONNES AU db GRACE AU ESP8266      //
/////////////////////////////////////////////////////////

include('./../interface/connection/connection_db.php');
$temperature =number_format(mt_rand(0, 520) / 10, 1); //$_GET['temperature']; 
$humidite = number_format(mt_rand(0, 220) / 10, 1); //$_GET['humidite'];
$sql = "INSERT INTO mesure (temperature, humidite) VALUES ($temperature, $humidite)";

// Exécution de la commande SQL
if (mysqli_query($conn, $sql)) {
    //Nouvelle valeur enregistrée 
    echo "T= $temperature, H = $humidite<br>";
} else {
    echo "Erreur lors de l'insertion des données : " . mysqli_error($conn);
}

// Fermeture de la connexion
mysqli_close($conn);
?>




