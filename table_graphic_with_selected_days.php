<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Table Chart</title>
</head>

<body>
    <div id="background-paragraph"></div>
    <section id="menu">
        <header>
            <h1>Cleiton Restaurant</h1>
            <nav>
                <ul>
        	<li><a href="/">Home</a></li>
	          <li><a href="cancel.php">Cancellations</a></li>
		  <li><a href="profit_graphic_with_selected_days.php">Days chart</a></li>
	 	  <li><a href="table_graphic_with_selected_days.php">Table chart</a></li>
		  <li><a href="beverage_profit_graphic.php">Beverage chart</a></li>
        	  <li><a href="stock.php">Stock</a></li>
		  <li><a href="add_beverage.php">Add beverage</a></li>
                </ul>
            </nav>
        </header>
    </section>
    <div class="background_graphic" style="background: white;margin-left: 110px;margin-right: 137px;border-radius: 24px;">
        <center>
            <div class="main">
                <canvas id="myChart" width="1080" height="600"></canvas>

                <!-- Atualizado para buscar mesas na tabela correta -->
                <label for="numero_mesa">Table number:</label>
                <select id="tableSelector" name="numero_mesa">
                    <?php
                    $servername = "mysql-server";
                    $username = "root";
                    $password = "lritzke";
                    $database = "restaurant_registration";

                    $conn = new mysqli($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Error connecting to the database: " . $conn->connect_error);
                    }

                    // Buscar todas as mesas disponíveis
                    $buscar_mesas = "SELECT number_table FROM tables;";
                    $result = $conn->query($buscar_mesas);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["number_table"] . "'>" . $row["number_table"] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>

                <button onclick="fetchDataAndDrawChart()">Show Data</button>
            </div>
        </center>

        <script>
            var chart;

            function createChart(labels, data) {
                var canvas = document.getElementById('myChart');
                var ctx = canvas.getContext('2d');

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            label: 'Total Hours',
                            borderColor: 'black',
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'darkgoldenrod'
                        }]
                    },
                    options: {
                        responsive: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 0,
                                max: 8, // Horas em um dia
                                ticks: {
                                    stepSize: 1,
                                    maxTicksLimit: 13 // Ajuste conforme necessário
                                }
                            }
                        }
                    }
                });
            }

            function fetchDataAndDrawChart() {
                var tableSelector = document.getElementById('tableSelector');
                var selectedTable = tableSelector.value;

                var url;
                if (selectedTable === 'all') {
                    url = `fetch_table.php?table_number=all&days=10`;
                } else {
                    url = `fetch_table.php?table_number=${selectedTable}&days=10`;
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Data received:', data);

                        var labels = data.map(row => row.day);
                        var hours = data.map(row => row.total_hours);

                        console.log('Labels:', labels);
                        console.log('Hours:', hours);

                        chart.data.labels = labels;
                        chart.data.datasets[0].data = hours;
                        chart.update();
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            $(document).ready(function () {
                createChart([], []);
                fetchDataAndDrawChart();
            });
        </script>
    </div>
</body>

</html>

