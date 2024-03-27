<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "iot_bd";

    // Connexion à la base de données
    $conn = mysqli_connect($hostname, $username, $password, $database);

    // Vérification de la connexion
    if (!$conn) {
        die("Connexion échouée : " . mysqli_connect_error());
    }

    // Requête SQL pour récupérer la dernière entrée de mesure
    $sql = "SELECT temperature, humidite FROM mesure ORDER BY id DESC LIMIT 1";

    // Exécution de la requête SQL
    $result = mysqli_query($conn, $sql);

    // Vérification des erreurs
    if (!$result) {
        die("Erreur de requête SQL : " . mysqli_error($conn));
    }

    // Vérification s'il y a des données trouvées
    if (mysqli_num_rows($result) > 0) {
        // Récupération des données
        $row = mysqli_fetch_assoc($result);
        $temperature = $row["temperature"];
        $humidite = $row["humidite"];


        $classeTemperature = "temperature";
        $classeHumidite = "temperature";
        // Affichage des données
        echo "<div class=\"$classeTemperature\">$temperature C°</div> " . "<div class=\"$classeHumidite\">$humidite %</div> ";
    } else {
        // Cas où aucune donnée n'est trouvée
        echo "Aucune donnée trouvée.";
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($conn);
?>
