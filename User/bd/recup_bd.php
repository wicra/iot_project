<!DOCTYPE html>
<html>
<head>
    <title>Actualisation des données en temps réel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../User/app/chart.js"></script>

    <link rel="stylesheet" href="../User/interface/styles/style.css">
</head>
<body>
    



    <!-- Affichage du graphique -->
    <div class="graphique">
        <canvas id="myChart" aria-laber="" role="img">

        </canvas>
    </div>


    <?php
    // Connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "", "iot_bd");

    // Vérifier la connexion
    if (!$conn) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Récupérer les données de la table "mesure"
    $sql = "SELECT  temperature, humidite ,historique FROM mesure";
    $result = mysqli_query($conn, $sql);

    // Créer des tableaux pour stocker les données
    $labels = [];
    $temperature = [];
    $humidite = [];

    // Parcourir les résultats de la requête et stocker les données dans les tableaux
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $temperature[] = $row['temperature'];
            $humidite[] = $row['humidite'];
            $labels[] = $row['historique'];
        }
    } else {
        echo "Aucune donnée trouvée.";
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>

    <script>
        // Utiliser les données récupérées en PHP
        const labels = <?php echo json_encode($labels); ?>;
        const temperature = <?php echo json_encode($temperature); ?>;
        const humidite = <?php echo json_encode($humidite); ?>;

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
                            parser: 'YYYY-MM-DD HH:mm:ss',
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
