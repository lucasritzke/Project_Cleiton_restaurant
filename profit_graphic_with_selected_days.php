<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Profit Chart</title>
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
                <button onclick="fetchDataAndDrawChart('all')">Show Total Price</button>
                <button onclick="fetchDataAndDrawChart('drinks')">Show Beverage Total Price</button>
                <button onclick="fetchDataAndDrawChart('buffet')">Show Buffet Total Price</button>
            </div>
        </center>

        <script>
            var chart;

            function createChart(labels, data, min, max) {
                var canvas = document.getElementById('myChart');
                var ctx = canvas.getContext('2d');

                chart = new Chart(ctx, {
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
                                    maxTicksLimit: 21, // Adjust as needed
                                    callback: function (value) {
                                        return Number(value).toFixed(0); // Exibe números inteiros
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function fetchDataAndDrawChart(profitType) {
                $.ajax({
                    url: `fetch_data.php?profit_type=${profitType}&days=10`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Data received:', data);

                        var labels = data.map(row => row.DAY);
                        var prices = data.map(row => row.total_price);

                        var minValue = Math.min(...prices) - 200;
                        var maxValue = Math.max(...prices) + 200;

                        console.log('Labels:', labels);
                        console.log('Prices:', prices);

                        chart.data.labels = labels;
                        chart.data.datasets[0].data = prices;
                        chart.options.scales.y.min = minValue;
                        chart.options.scales.y.max = maxValue;
                        chart.update();
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            $(document).ready(function() {
                createChart([], [], 0, 20000);  
                fetchDataAndDrawChart('all');
            });
        </script>
    </div>
</body>

</html>

