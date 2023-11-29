<?php
$servername = "mysql-server";
$username = "root";
$password = "lritzke";
$database = "restaurant_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$conn->begin_transaction();

try {
    $fullname = $_POST['fullname'];
    $birthdate = $_POST['birthdate'];
    $cpf = $_POST['cpf'];
    $itemsBought = json_decode($_POST['itemsBought'], true);

    $insertProfitsQuery = "INSERT INTO total_profits (which_profit, amount, total_price, profit_type, DAY) VALUES (?, ?, ?, ?, CURDATE()) 
                          ON DUPLICATE KEY UPDATE amount = amount + VALUES(amount), total_price = total_price + VALUES(total_price), DAY = IF(DAY <> CURDATE(), CURDATE(), DAY)";
    $stmtProfits = $conn->prepare($insertProfitsQuery);

    foreach ($itemsBought as $item) {
        $whichProfit = $item['name'];
        $amount = $item['quantity'];

        // Determine o valor de profit_type com base em which_profit
        $profitType = getProfitType($whichProfit);

        // Busque o preço do item na tabela de preços
        $pricePerProfitResult = $conn->query("SELECT price FROM prices WHERE names='$whichProfit'");
        $pricePerProfit = $pricePerProfitResult->fetch_assoc()['price'];
        $totalPrice = $amount * $pricePerProfit;

        // Adicione a variável $day
        $day = date('Y-m-d');

        // Insira ou atualize os dados na tabela total_profits
        $stmtProfits->bind_param("sids", $whichProfit, $amount, $totalPrice, $profitType);
        $stmtProfits->execute();
    }

    $stmtProfits->close();

    // Atualize a quantidade de bebidas na tabela drinks
    $updateDrinksQuery = "UPDATE drinks SET amount = amount - ? WHERE name = ?";
    $stmtUpdateDrinks = $conn->prepare($updateDrinksQuery);

    foreach ($itemsBought as $item) {
        $stmtUpdateDrinks->bind_param("is", $item['quantity'], $item['name']);
        $stmtUpdateDrinks->execute();
    }

    $stmtUpdateDrinks->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Pedido processado com sucesso!']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Erro ao processar o pedido: ' . $e->getMessage()]);
}

$conn->close();

// Função para determinar o valor de profit_type com base em which_profit
function getProfitType($whichProfit)
{
    if (strpos($whichProfit, 'buffet') !== false) {
        return 'buffet';
    } else {
        return 'drinks';
    }
}
?>

