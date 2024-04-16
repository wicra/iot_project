<?php
/////////////////////////////////////////////////////////
//       AJOUTE DES DONNES AU db GRACE AU ESP8266      //
/////////////////////////////////////////////////////////

include('./../interface/connection/connection_db.php');
$temperature = $_GET['temperature']; 
$humidite = $_GET['humidite'];
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




