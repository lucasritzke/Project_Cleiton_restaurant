<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add drink</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
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
          <li><a href="add_beverage.php">Add beverage </a></li>
        </ul>
      </nav>
    </header>
  </section>
  <main>
    <section>
      <form action="" method="post">
        <h2 style="color: black;">Add new Beverage:</h2>
        <label for="drinkName">Beverage name:</label>
        <input type="text" id="drinkName" name="drinkName" style="width: 472px;" required><br>

        <label for="drinkPrice">Price:</label>
        <input type="text" id="drinkPrice" name="drinkPrice" style="width: 472px;" pattern="[0-9]+(\.[0-9]{2})?" title="Enter a valid price (e.g., 10.99)" required><br>

        <label for="drinkAmount">Amount:</label>
        <input type="text" id="drinkAmount" name="drinkAmount" style="width: 472px;" pattern="[0-9]+" title="Enter a valid quantity (e.g., 10)" required><br>

        <button type="submit">Add beverage</button>
      </form>

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

          $drinkName = $_POST["drinkName"];
          $drinkPrice = $_POST["drinkPrice"];
          $drinkAmount = $_POST["drinkAmount"];

          // Validar o preço no lado do servidor
          if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $drinkPrice)) {
              echo "Erro: Formato inválido para o preço.";
              $conn->close();
              exit;
          }

          // Validar a quantidade no lado do servidor
          if (!preg_match("/^[0-9]+$/", $drinkAmount)) {
              echo "Erro: A quantidade deve ser um número inteiro.";
              $conn->close();
              exit;
          }

          $sql = "INSERT INTO drinks (name, price, amount) VALUES ('$drinkName', '$drinkPrice', '$drinkAmount')";

          if ($conn->query($sql) === TRUE) {
              echo "Bebida adicionada com sucesso!";
          } else {
              echo "Erro ao adicionar bebida: " . $conn->error;
          }

          $conn->close();
      }
      ?>
    </section>
  </main>
</center>
</body>
</html>

