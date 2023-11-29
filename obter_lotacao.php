<?php
// obter_lotacao.php

$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

// Cria uma conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $selectedDate = $_GET["data"];

    // Total number of tables in the restaurant
    $totalTables = 12;

    // Total number of hours the restaurant is open
    $totalHours = 8; // (from 16:00 to 00:00)

    // Query para obter todas as reservas para a data selecionada
    $query = "SELECT table_number, enter_time, leave_time FROM system_reservations WHERE day = '$selectedDate'";
    $result = $conn->query($query);

    $reservedTables = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $enterTime = strtotime($row["enter_time"]);
            $leaveTime = strtotime($row["leave_time"]);

            // Calculate the reservation duration in hours
            $reservationDuration = ($leaveTime - $enterTime) / 3600;

            // Assuming each reservation is for one table
            $reservedTables += $reservationDuration;
        }

        // Calculate the percentage of reserved tables
        $percentage = ($reservedTables / ($totalTables * $totalHours)) * 100;

        // Ensure the percentage does not exceed 100%
        $percentage = min($percentage, 100);

        echo $percentage;
    } else {
        echo "0"; // Se não houver reservas, a lotação é zero.
    }
}

// Fecha a conexão
$conn->close();
?>
