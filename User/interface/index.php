<!DOCTYPE html>
<html>
    <head>
        <title>Actualisation des données en temps réel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="app/chart.js"></script>

        <link rel="stylesheet" href="style.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    </head>
    <body>

    <style>


    </style>
        <!-- CONNECTION ADMIN -->
        <a href="../../Admin/formulaire_connection.php">User</a>



        <!-- AFFICHAGE des données -->
        <div id="data">
            <!-- Les données seront affichées ici -->
        </div>
        

        <script>
            $(document).ready(function() {
                function fetchData() {
                    $.ajax({
                        url: '../bd/affichage-donne.php', // Chemin vers le script PHP qui récupère les données
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


    <!-- Affichage du graphique -->
    <div class="graphique">
        <canvas id="graphique" aria-laber="" role="img">

        </canvas>
    </div>

    <!-- Link CHARTJS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>   

 
    <script>
        // Données pour le graphique
        const labels = ['2024-01-01', '2024-01-02', '2024-01-03', '2024-01-04', '2024-01-05'];
        const temperature = [23, 24, 22, 25, 24]; // Température en degrés Celsius
        const humidite = [70, 72, 68, 75, 73]; // Humidité en pourcentage

        // Création du graphique
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Température (°C)',
                    data: temperature,
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1,
                    fill: false
                }, {
                    label: 'Humidité (%)',
                    data: humidite,
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            parser: 'YYYY-MM-DD',
                            tooltipFormat: 'll'
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Valeur'
                        }
                    }
                }
            }
        });
    </script>


    </body>
</html>
