<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="background-paragraph"></div>
    <section id="menu">
        <header>
            <h1>Cleiton Restaurant</h1>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="shopping.php">Reservations</a></li>
                    <li><a href="total_occupancy.php">Total occupancy</a></li>
                </ul>
            </nav>
        </header>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $servername = "mysql-server";
        $username = "root";
        $password = "lritzke";
        $database = "restaurant_registration";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Error connecting to the database: " . $conn->connect_error);
        }

        $cliente_nome = $_POST["cliente_nome"];
        $numero_mesa = $_POST["numero_mesa"];
        $data_reserva = $_POST["data_reserva"];
        $enter_time = $_POST["enter_time"];
        $leave_time = $_POST["leave_time"];

        // Calcular a diferença de tempo entre enter_time e leave_time
        $diff = strtotime($leave_time) - strtotime($enter_time);
        $diff_in_hours = floor($diff / 3600); // Obter a diferença em horas

        $verificar_disponibilidade = "SELECT * FROM system_reservations WHERE table_number = $numero_mesa AND day = '$data_reserva' 
            AND (
                (enter_time <= '$enter_time' AND leave_time >= '$enter_time') OR
                (enter_time <= '$leave_time' AND leave_time >= '$leave_time')
            )";

        $result = $conn->query($verificar_disponibilidade);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reservado_por = $row["customer"];
            $horario_reserva = $row["enter_time"] . " - " . $row["leave_time"];

            echo "<div style=\"background-color: white;width: 535px;margin-left: 18px;border-radius: 9px;\"><h3>Sorry, the table is already reserved for this time by $reservado_por, at $horario_reserva.</h3></div>";
        } else {
            // Inserir na tabela system_reservations
            $inserir_reserva = "INSERT INTO system_reservations (customer, table_number, day, enter_time, leave_time, reservation) 
                VALUES ('$cliente_nome', $numero_mesa, '$data_reserva', '$enter_time', '$leave_time', '1')";
            $conn->query($inserir_reserva);

            // Inserir na tabela reserved_tables
            $inserir_reserved_table = "INSERT INTO reserved_tables (number_table, customer_name, DAY, time) 
                VALUES ($numero_mesa, '$cliente_nome', '$data_reserva', '$diff_in_hours:00')";
            $conn->query($inserir_reserved_table);

            echo "<div style=\"background-color: white;width: 306px;margin-left: 19px;border-radius: 7px;\"><h3>Reservation made successfully!</h3></div>";
        }

        $conn->close();
    }
    ?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-row">
            <div class="form-column">

        <div class="form-column">
            <label for="cliente_nome">Customer name:</label>
            <input type="text" name="cliente_nome" required>
            <br>

            <label for="numero_mesa">Table number:</label>
            <select name="numero_mesa">
            <?php
            $servername = "mysql-server";
            $username = "root";
            $password = "lritzke";
            $database = "restaurant_registration";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Error connecting to the database: " . $conn->connect_error);
            }

            // Fetch available table numbers
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
            <br>

            <label for="data_reserva">Reservation Date:</label>
            <input type="date" id="data_reserva" name="data_reserva" required onchange="validateDate()">
            <br>

            <script>
            function validateDate() {
                var reservationDate = document.getElementById('data_reserva').value;
                var today = new Date();
                var reservationDateObj = new Date(reservationDate);
                var midnightToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                if (reservationDateObj < midnightToday) {
                    document.getElementById('data_reserva').valueAsDate = midnightToday;
                }
            }
            </script>

            <div id="popup"  style="position: fixed; right: 0px; top: 0px; display: block; margin-top: 415px; margin-left: 242px; border-radius: 14px;width: 627px;" >
                <h2>Restaurant map</h2>
                <img src="https://github.com/lucasritzke/Project_Cleiton_restaurant/blob/main/restaurant_map.png?raw=true" alt="Restaurant Image" style="width: 39pc;" >
                <button onclick="closePopup()">Close</button>
            </div>
            <div id="overlay" onclick="closePopup()"></div>

            <script>

		    function openPopup() {
        var popup = document.getElementById('popup');
        var overlay = document.getElementById('overlay');
        popup.style.position = 'fixed';
        popup.style.right = '0';
        popup.style.top = '0';
        popup.style.display = 'block';
        overlay.style.display = 'block';
    }
                function closePopup() {
                    var popup = document.getElementById('popup');
                    var overlay = document.getElementById('overlay');
                    popup.style.display = 'none';
                    overlay.style.display = 'none';
                }

	        document.getElementById('displayRestaurantLink').addEventListener('click', openPopup);
    document.getElementById('popup').querySelector('button').addEventListener('click', closePopup);
    document.getElementById('overlay').addEventListener('click', function (event) {
        if (event.target.id === 'overlay') {
            closePopup();
        }
    });
            </script>

            <script>
                function validateTime() {
                    var time1Input = document.getElementById("time1");
                    var time2Input = document.getElementById("time2");

                    var selectedTime1 = new Date("2000-01-01T" + time1Input.value + ":00");
                    var selectedTime2 = new Date("2000-01-01T" + time2Input.value + ":00");

                    var minReservationDuration = 30 * 60 * 1000; // 30 minutes in milliseconds

                    if (time1Input.value === time2Input.value) {
                        time1Input.setCustomValidity('Entry and exit times cannot be equal');
                        time2Input.setCustomValidity('Entry and exit times cannot be equal');
                        return;
                    } else {
                        time1Input.setCustomValidity('');
                        time2Input.setCustomValidity('');
                    }

                    if (selectedTime1 > selectedTime2) {
                        time1Input.setCustomValidity('Entry time cannot be after exit time');
                        time2Input.setCustomValidity('Exit time cannot be before entry time');
                        return;
                    } else {
                        time1Input.setCustomValidity('');
                        time2Input.setCustomValidity('');
                    }

                    var startTime = new Date("2000-01-01T16:00:00");
                    var endTime = new Date("2000-01-02T00:00:00");
                    var maxReservationDuration = 3 * 60 * 60 * 1000; // 3 hours in milliseconds

                    if (selectedTime1 >= startTime && selectedTime1 <= endTime) {
                        time1Input.setCustomValidity('');
                    } else {
                        time1Input.setCustomValidity('Entry time must be between 16:00 and 00:00');
                    }

                    if (selectedTime2 >= startTime && selectedTime2 <= endTime) {
                        time2Input.setCustomValidity('');
                    } else {
                        time2Input.setCustomValidity('Exit time must be between 16:00 and 00:00');
                    }

                    if (selectedTime2 - selectedTime1 > maxReservationDuration) {
                        time2Input.setCustomValidity('Reservation cannot exceed 3 hours');
                    }
                    if (selectedTime2 - selectedTime1 < minReservationDuration) {
                        time2Input.setCustomValidity('Reservation must be at least 30 minutes');
                    } else {
                        time2Input.setCustomValidity('');
                    }
                }
            </script>

                <button type="button" onclick="openPopup()">Display Map</button>
                <div class="form-column">
                    <label for="time1">Entry time:</label>
                    <input type="time" id="time1" name="enter_time" required oninput="validateTime()">
                    <br>
                    <div class="leave_time" style="margin-top: 27px;">
                        <label for="time2">Exit time:</label>
                        <input type="time" id="time2" name="leave_time" required oninput="validateTime()">
                        <h5 style="width: 457px;">Maximum 3-hour reservation allowed</h5>
                    </div>
                    <br>
                    <input type="submit" value="Reserve">
                </div>
            </div>
        </div>
    </form>

    <div id="popup" style="position: fixed; right: 0px; top: 0px; display: none; margin-top: 415px; margin-left: 242px; border-radius: 14px; width: 627px;">
        <h2>Restaurant map</h2>
        <img src="https://github.com/lucasritzke/Project_Cleiton_restaurant/blob/main/restaurant_map.png?raw=true" alt="Restaurant Image" style="width: 39pc;">
        <button onclick="closePopup()">Close</button>
    </div>
    <div id="overlay" onclick="closePopup()"></div>

    <script>
        function openPopup() {
            var popup = document.getElementById('popup');
            var overlay = document.getElementById('overlay');
            popup.style.position = 'fixed';
            popup.style.right = '0';
            popup.style.top = '0';
            popup.style.display = 'block';
            overlay.style.display = 'block';
        }

        function closePopup() {
            var popup = document.getElementById('popup');
            var overlay = document.getElementById('overlay');
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }

        document.getElementById('displayRestaurantLink').addEventListener('click', openPopup);
        document.getElementById('popup').querySelector('button').addEventListener('click', closePopup);
        document.getElementById('overlay').addEventListener('click', function (event) {
            if (event.target.id === 'overlay') {
                closePopup();
            }
        });
    </script>

</body>
</html>

