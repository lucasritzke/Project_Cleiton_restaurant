<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Drink Profit Chart</title>
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
		    <li><a href="beverage_profit_graphic.php">Beverage Chart</a></li>
                    <li><a href="stock.php">Stock</a></li>
                    <li><a href="add_beverage.php">Add beverage</a></li>
                </ul>
            </nav>
        </header>
    </section>
    <div class="background_graphic" style="background: white;margin-left: 110px;margin-right: 137px;border-radius: 24px;">
        <script>
            var drinkChart;

            function createDrinkChart(labels, data, min, max) {
                var canvas = document.getElementById('drinkChart');
                var ctx = canvas.getContext('2d');

                drinkChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            label: 'Total Price',
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
                                min: min,
                                max: max,
                                ticks: {
                                    stepSize: 200,
                                    maxTicksLimit: 21,
                                    callback: function (value) {
                                        return Number(value).toFixed(0);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function fetchDrinkDataAndDrawChart() {
                var selectedDrink = $('#drinkSelect').val();

                $.ajax({
                    url: `fetch_drink_data.php?drink_name=${selectedDrink}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Drink Data received:', data);

                        var labels = data.map(row => row.DAY);
                        var prices = data.map(row => row.total_price);

                        var minValue = Math.min(...prices) - 200;
                        var maxValue = Math.max(...prices) + 200;

                        console.log('Labels:', labels);
                        console.log('Prices:', prices);

                        drinkChart.data.labels = labels;
                        drinkChart.data.datasets[0].data = prices;
                        drinkChart.options.scales.y.min = minValue;
                        drinkChart.options.scales.y.max = maxValue;
                        drinkChart.update();
                    },
                    error: function(error) {
                        console.error('Error fetching drink data:', error);
                    }
                });
            }

            $(document).ready(function() {
                createDrinkChart([], [], 0, 20000);
            });
        </script>
        <center>
        <canvas id="drinkChart" width="1080" height="600"></canvas>
            <div class="main">
                <form id="drinkForm">
                    <label for="drinkSelect">Select Drink:</label>
                    <select id="drinkSelect" name="drinkSelect">
                        <?php
                        // Connect to the database
                        $servername = "mysql-server";
                        $username = "root";
                        $password = "lritzke";
                        $database = "restaurant_registration";

                        $conn = new mysqli($servername, $username, $password, $database);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch all distinct drink names from the 'drinks' table
                        $query = "SELECT DISTINCT name FROM drinks";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['name']}'>{$row['name']}</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                    <button type="button" onclick="fetchDrinkDataAndDrawChart()">Show Profits</button>
                </form>

            </div>
        </center>
    </div>
</body>

</html>
