<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableNumber = isset($_GET['table_number']) ? $_GET['table_number'] : 'all';
$days = isset($_GET['days']) ? $_GET['days'] : 10;

// Criar um intervalo de datas para os últimos $days dias
$dateInterval = new DateInterval('P1D'); // Intervalo de 1 dia
$endDate = new DateTime(); // Data atual
$startDate = (new DateTime())->sub(new DateInterval('P' . ($days - 1) . 'D')); // Data há $days dias

// Representações de string das datas
$startDateStr = $startDate->format('Y-m-d');
$endDateStr = $endDate->format('Y-m-d');

$data = [];

// Consulta SQL para contar o número de horas de reserva para cada dia e mesa
if ($tableNumber === 'all') {
    $query = "SELECT DAY, TRIM(TRAILING '.00' FROM ROUND(SUM(hours), 2)) AS total_hours
              FROM (
                  SELECT DAY, 
                      (HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(time)))) * 60 + MINUTE(SEC_TO_TIME(SUM(TIME_TO_SEC(time))))) / 60 AS hours
                  FROM reserved_tables 
                  WHERE DAY BETWEEN ? AND ?
                  GROUP BY DAY, number_table
              ) AS subquery
              GROUP BY DAY
              ORDER BY DAY DESC
              LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $startDateStr, $endDateStr);
} else {
    $query = "SELECT DAY, TRIM(TRAILING '.00' FROM ROUND(SUM(hours), 2)) AS total_hours
              FROM (
                  SELECT DAY, 
                      (HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(time)))) * 60 + MINUTE(SEC_TO_TIME(SUM(TIME_TO_SEC(time))))) / 60 AS hours
                  FROM reserved_tables 
                  WHERE DAY BETWEEN ? AND ? AND number_table = ?
                  GROUP BY DAY, number_table
              ) AS subquery
              GROUP BY DAY
              ORDER BY DAY DESC
              LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $startDateStr, $endDateStr, $tableNumber);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'day' => $row['DAY'],
        'total_hours' => $row['total_hours']
    ];
}

echo json_encode($data);

$conn->close();
?>

