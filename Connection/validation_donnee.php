<?php

include_once('connection_bd.php'); // Inclut le fichier de connexion à la base de données.

function test_input($data) { // Fonction pour nettoyer les données d'entrée.

    $data = trim($data); // Supprime les espaces en début et fin de chaîne.
    $data = stripslashes($data); // Supprime les antislashs d'une chaîne.
    $data = htmlspecialchars($data); // Convertit les caractères spéciaux en entités HTML.
    return $data; // Retourne les données nettoyées.
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Vérifie si la méthode de requête est POST.

    $username = test_input($_POST["username"]); // Nettoie le nom d'utilisateur envoyé via POST.
    $password = test_input($_POST["password"]); // Nettoie le mot de passe envoyé via POST.

    // Vérifie si l'utilisateur est dans la table adminlogin.
    $stmt_admin = $conn->prepare("SELECT * FROM adminlogin WHERE username = ? AND password = ?");
    $stmt_admin->bindParam(1, $username);
    $stmt_admin->bindParam(2, $password);
    $stmt_admin->execute(); // Exécute la requête.
    $admin_user = $stmt_admin->fetch(); // Récupère le premier résultat de la requête.

    if($admin_user) { // Si l'utilisateur est trouvé dans la table adminlogin.
        header("location: ../Admin/adminpage.php"); // Redirige vers la page d'administration.
    } else {
        $stmt_other = $conn->prepare("SELECT * FROM utilisateurs WHERE nomutilisateur = ? AND motdepasse = ?");
        $stmt_other->bindParam(1, $username);
        $stmt_other->bindParam(2, $password);
        $stmt_other->execute(); // Exécute la requête.
        $other_user = $stmt_other->fetch(); 

        if($other_user) { // Si l'utilisateur est trouvé dans l'autre table.
            header("location: ../User/interface/index.php"); 
        } else { 
            echo "<script language='javascript'>"; 
            echo "alert('Information incorecte ou vous ete pas inscrit')"; 
            echo "</script>"; 
            die(); 
        }
    }
}

?>
