<!DOCTYPE html>
<html>
<head>
    <title>Actualisation des données en temps réel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../User/app/chart.js"></script>

    <!-- ICON-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="adminpage.css">
</head>
<body>
    
    <!-- NAV BARRE -->
    <header>
        <div class="nav-barre">
            <a class="connection" href="Connection/formulaire_connection.php">
                <i class="fa-solid fa-user"></i>
                <h2>Admin</h2>
            </a>            

        </div>        
    </header>

    <!-- Affichage du graphique -->
    <div class="graphique">
        <canvas id="graphique" aria-laber="" role="img">

        </canvas>
    </div>

    <!-- Link CHARTJS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>   

    
    <script>
        // GRAPHIQUE
        const Mongraphique = document.getElementById('graphique');

        new Chart(Mongraphique, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
        });
    </script> 


    <!-- Affichage du graphique -->
    <div class="graphique">
        <canvas id="myChart" aria-laber="" role="img">

        </canvas>
    </div>


    <script>
        // Données pour le graphique
        const labels = ['2024-03-25 08:00:00', '2024-03-25 09:00:00', '2024-03-25 10:00:00', '2024-03-25 11:00:00', '2024-03-25 12:00:00', '2024-03-25 13:00:00', '2024-03-25 14:00:00', '2024-03-25 15:00:00', '2024-03-25 16:00:00', '2024-03-25 17:00:00'];
        const temperature = [25, 26, 27, 26, 27, 28, 29, 28, 27, 26]; // Température en degrés Celsius
        const humidite = [60, 61, 62, 63, 64, 65, 66, 67, 68, 69]; // Humidité en pourcentage

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
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>




    <!-- AFFICHAGE des données -->
    <div id="data">
        <!-- Les données seront affichées ici -->
    </div>



    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: '../User/bd/affichage-donne.php', // Chemin vers le script PHP qui récupère les données
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
