<!DOCTYPE html>
<html>
<head>
    <title>Actualisation des données en temps réel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="data">
        <!-- Les données seront affichées ici -->
    </div>

    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: 'affichage-donne.php', // Chemin vers le script PHP qui récupère les données
                    method: 'GET',
                    success: function(response) {
                        $('#data').html(response); // Mettre à jour le contenu de la zone de données
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des données:', error);
                    },
                    complete: function() {
                        // Répéter le processus toutes les 2 secondes
                        setTimeout(fetchData, 2000);
                    }
                });
            }

            // Appel initial pour démarrer la récupération des données
            fetchData();
        });
    </script>
</body>
</html>
