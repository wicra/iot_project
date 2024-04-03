<?php
include('./../../connection/connection_db.php');


$tableName = 'mesure';

$sql = "TRUNCATE TABLE $tableName";

// Exécution de la requête
if (mysqli_query($conn, $sql)) {
    // La base a été vider avec succès
    header("location: ./../../connection/formulaire_connection.php");
} else {
    echo "Erreur lors de la tentative de vidage de la table $tableName : " . mysqli_error($conn);
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
