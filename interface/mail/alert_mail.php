<?php
$to = "destination@example.com";
$subject = "Test d'envoi d'e-mail";
$message = "Ceci est un test d'envoi d'e-mail en PHP.";
$headers = "From: expéditeur@example.com";

// Envoi de l'e-mail
if (mail($to, $subject, $message, $headers)) {
    echo "E-mail envoyé avec succès !";
} else {
    echo "Erreur lors de l'envoi de l'e-mail.";
}
?>

