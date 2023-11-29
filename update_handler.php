<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $id = $_POST["id"];
    $newName = $_POST["newName"];
    $newPrice = $_POST["newPrice"];
    $newAmount = $_POST["newAmount"];

    // Adicione validações adicionais, se necessário

    // Atualizar o banco de dados
    $sql = "UPDATE drinks SET name='$newName', price='$newPrice', amount='$newAmount' WHERE id_drink='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Atualização bem-sucedida!";
    } else {
        echo "Erro na atualização: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Método não permitido.";
}
?>

