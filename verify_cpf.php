<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

// Obtém o CPF enviado via POST
$cpfToVerify = $_POST['cpf'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o CPF já existe no banco de dados
$checkCpfQuery = $conn->prepare("SELECT name, birth_date FROM customers WHERE cpf = ?");
$checkCpfQuery->bind_param("s", $cpfToVerify);
$checkCpfQuery->execute();
$checkCpfQuery->store_result();

if ($checkCpfQuery->num_rows > 0) {
    // Se o CPF existe, obtemos os dados do cliente
    $checkCpfQuery->bind_result($fullname, $birthdate);
    $checkCpfQuery->fetch();

    $response = array(
        'exists' => true,
        'fullname' => $fullname,
        'birthdate' => $birthdate
    );
} else {
    // Se o CPF não existe, retornamos que não existe
    $response = array('exists' => false);
}

$checkCpfQuery->close();
$conn->close();

// Retorna a resposta em formato JSON
echo json_encode($response);
?>

