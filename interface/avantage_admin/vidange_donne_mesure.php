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

$tableName = 'mesure';

$sql = "TRUNCATE TABLE $tableName";

// Exécution de la requête
if (mysqli_query($conn, $sql)) {
    // La base a été vider avec succès
    header("location: ./../connection/formulaire_connection.php");
} else {
    echo "Erreur lors de la tentative de vidage de la table $tableName : " . mysqli_error($conn);
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
