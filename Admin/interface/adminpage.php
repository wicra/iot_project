<!DOCTYPE html>
<html>
    <head>
        <title>Page/Admin</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../User/app/chart.js"></script>

        <!-- ICON -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- CSS -->
        <link rel="stylesheet" href="styles/adminpage.css">

        <!-- FONT -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

        <!-- CHART -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    </head>

    <body>
        <!-- NAV BARRE -->
        <header>
            <div class="user">
                <a class="user_connecter" href="#">
                    <i class="fa-solid fa-user"></i>
                    <h2>ADMIN</h2>
                </a> 

                <ul>
                    <a href="../../index.php">Deconnection</a>
                    <a href="">Projet</a>
                    <a href="http://localhost/phpmyadmin/">Base-donnee</a>
                </ul>

            </div>
        </header>

        <!-- INTERFACE -->
        <div id="data">
            <!-- Les données seront affichées ici -->
        </div>

        <!-- CHART -->
        <div class="historique">
            <div class="graphique">
                <canvas id="graphique" aria-laber role="img" > </canvas>
            </div>
        </div>

        <!-- SCRIPT AJAX VALEUR TEMPS REEL-->
        <script>
            $(document).ready(function() {
                function fetchData() {
                    $.ajax({
                        url: '../../bd/affichage-donne.php', // Chemin vers le script PHP qui récupère les données
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

        <!-- SCRIPT RECUPERATION DE DONNEE SQL POUR CHART -->
        <?php
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $database = "iot_bd";

            // Connexion à la base de données
            $con = mysqli_connect($hostname, $username, $password, $database);

            // Vérification de la connexion
            if (!$con) {
                die("Connection échouée : " . mysqli_connect_error());
            }

            // Requête pour afficher les valeurs à partir de la date limite
            $req = mysqli_query($con, "SELECT temperature, humidite, historique FROM mesure ");

            // Vérification de la réussite de la requête
            if (!$req) {
                die("Erreur dans la requête : " . mysqli_error($con));
            }

            // Initialisation des tableaux
            $temperature = [];
            $humidite = [];
            $historique = [];

            // Boucle pour mettre les données dans les tableaux
            while ($data = mysqli_fetch_assoc($req)) {
                $temperature[] = $data['temperature'];
                $humidite[] = $data["humidite"];
                $historique[] = $data["historique"];
            }
        ?>

        <!-- CHARTJS SCRIPT AFFICHAGE-->
        <script>
            Chart.defaults.borderColor = '#fff';
            Chart.defaults.color = '#ffff';
            Chart.defaults.font.size = 18;

            // Données pour le graphique
            const labels = <?php echo json_encode($historique) ?>;
            const temperature = <?php echo json_encode($temperature) ?>; // Température en degrés Celsius
            const humidite = <?php echo json_encode($humidite) ?>; // Humidité en pourcentage

            // Création du graphique
            const ctx = document.getElementById('graphique').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Température (°C)',
                        data: temperature,
                        borderColor: '#b0f2b6',
                        borderWidth: 2,
                        fill: false ,
                        backgroundColor: '#fff'
                    }, {
                        label: 'Humidité (%)',
                        data: humidite,
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 2,
                        fill: false,
                        backgroundColor: '#fff'
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    family: "'DotGothic16'"
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </body>
</html>
