<?php
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//              AFFICHE LES DONNES DU db               //
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

include('./../interface/connection/connection_db.php');
$sql = "SELECT temperature, humidite FROM mesure ORDER BY id DESC LIMIT 1";

// Exécution de la requête SQL
$result = mysqli_query($conn, $sql);

// Vérification s'il y a des données trouvées
if (mysqli_num_rows($result) > 0) {
    // Récupération des données
    $row = mysqli_fetch_assoc($result);
    $temperature = $row["temperature"];
    $humidite = $row["humidite"];

    $classeTemperature = "temperature";
    $classeHumidite = "temperature";
    $classeTemperatureTitre = "temperatureTitre";
    $classeHumiditeTitre = "temperatureTitre";
    $classeTemperatureValeur = "temperatureValeur";
    $classeHumiditeValeur = "temperatureValeur";
    $classeUnite = "classeUnite";

    $classeIconTemperature = "fa-solid fa-temperature-three-quarters";
    $classeIconHumidite = "fa-solid fa-droplet"; 
    // Affichage des données
    echo "<div class=\"$classeTemperature\">
            <div class=\"$classeTemperatureTitre\">Temperature Actuelle</div>
            <div class=\"$classeTemperatureValeur\">
                $temperature <span class=\" $classeUnite\">C°</span> 
                <i class=\"$classeIconTemperature\"></i>
            </div>
        </div> " . 
        "<div class=\"$classeHumidite\">
            <div class=\"$classeHumiditeTitre\">Humidite Actuelle</div>
            <div class=\"$classeHumiditeValeur\">
                $humidite <span class=\" $classeUnite\">%</span>
                <i class=\"$classeIconHumidite\"></i>
            </div>
        </div> ";
} else {
    echo "Aucune donnée trouvée.";
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
