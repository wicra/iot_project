<?php
/////////////////////////////////////////////////////////
//                        SESSION                     //
/////////////////////////////////////////////////////////

session_start();
// Verif si user connecter si la variable $_SESSION comptien le username 
if(!isset($_SESSION["username"])){
    header("location: ./../connection/formulaire_connection.php");
exit(); 
}

// déconnection
if(isset($_POST['deconnection'])){
    session_destroy();
    header('location: ./../connection/formulaire_connection.php');
}

/////////////////////////////////////////////////////////
//                  RECUP DONNE CHART                  //
///////////////////////////////////////////////////////// 

include('./../connection/connection_db.php');
$req = mysqli_query($conn, "SELECT temperature, humidite, historique FROM mesure ");

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

<!DOCTYPE html>
<html>
    <head>
        <title>Page/User</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- ICON -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- CSS -->
        <link rel="stylesheet" href="./../styles/userpage.css">

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
                    <h2><?php echo $_SESSION["username"] ?></h2>
                </a> 

                <ul>
                    <form  method='POST'>
                        <button type='submit' name='deconnection' style="font-family : 'DotGothic16' ; background-color: #212121; border:none ; color:white ;font-size: 18px;"  >Deconnection</button>
                    </form>
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


        <!--***********************************************************
        **********        SCRIPT AJAX VALEUR TEMPS REEL          *******
        *************************************************************-->
        <script>
            /////////////////////////////////////////////////////////
            //                    POUR LES DONNEES                 //
            /////////////////////////////////////////////////////////
            $(document).ready(function() {
                function fetchData() {
                    $.ajax({
                        url: './../../db/recuperation_donnee_mesure.php',
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
                fetchData();
            });

            /////////////////////////////////////////////////////////
            //                     POUR LES CHART                  //
            ///////////////////////////////////////////////////////// 
            
            $(document).ready(function() {
                function fetchChartData() {
                    $.ajax({
                        url: './../../db/recuperation_donnee_chart.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Mettre à jour les données du graphique avec les données reçues
                            myChart.data.labels = data.historique;
                            myChart.data.datasets[0].data = data.temperature;
                            myChart.data.datasets[1].data = data.humidite;
                            myChart.update(); // Mettre à jour le graphique
                        },
                        error: function(xhr, status, error) {
                            console.error('Erreur AJAX: ' + status, error);
                        }
                    });
                }
                setInterval(fetchChartData, 1000);
            });

            /////////////////////////////////////////////////////////
            //              CHARTJS SCRIPT AFFICHAGE               //
            /////////////////////////////////////////////////////////

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
