<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$profitType = $_GET['profit_type'];
$days = $_GET['days'];

// Ajuste para incluir todos os tipos de lucro se profit_type for 'all'
if ($profitType === 'all') {
    $query = "SELECT DAY, SUM(total_price) as total_price
              FROM total_profits
              WHERE DAY >= CURDATE() - INTERVAL $days DAY
              GROUP BY DAY
              ORDER BY DAY";
} else {
    $query = "SELECT DAY, SUM(total_price) as total_price
              FROM total_profits
              WHERE profit_type = '$profitType' AND DAY >= CURDATE() - INTERVAL $days DAY
              GROUP BY DAY
              ORDER BY DAY";
}

$result = $conn->query($query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>

