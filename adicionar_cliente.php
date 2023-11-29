<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$cpf = $_POST['cpf'];

// Verificar se o CPF já existe na tabela customers
$checkCpfQuery = "SELECT COUNT(*) as count FROM customers WHERE CPF = ?";
$stmtCheckCpf = $conn->prepare($checkCpfQuery);
$stmtCheckCpf->bind_param("s", $cpf);
$stmtCheckCpf->execute();
$result = $stmtCheckCpf->get_result();
$count = $result->fetch_assoc()['count'];
$stmtCheckCpf->close();

if ($count == 0) {
    // CPF não existe, adicionar informações na tabela customers
    $fullname = $_POST['fullname'];
    $birthdate = $_POST['birthdate'];

    $insertCustomerQuery = "INSERT INTO customers (name, birth_date, CPF) VALUES (?, ?, ?)";
    $stmtInsertCustomer = $conn->prepare($insertCustomerQuery);
    $stmtInsertCustomer->bind_param("sss", $fullname, $birthdate, $cpf);
    $stmtInsertCustomer->execute();
    $stmtInsertCustomer->close();
}

$conn->close();
?>

