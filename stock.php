<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Cleiton</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
	  <li><a href="add_beverage.php">Add beverage</a></li>
        </ul>
      </nav>
    </header>
  </section>

  <main>
    <section style="background-color: #a8a8a8;width: 581px;border-radius: 15px;" >
      <h2 style="color: #000;">Beverage informations:</h2>
      <table>
        <tr>
          <th>Beverage name</th>
          <th>Price</th>
          <th>Amount</th>
          <th></th>
        </tr>
        <?php
        $servername = "mysql-server";
        $username = "root";
        $password = "lritzke";
        $database = "restaurant_registration"; 

        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
          die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM drinks;";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td><input type='text' id='name_$row[id_drink]' value='$row[name]'></td>";
          echo "<td><input type='text' id='price_$row[id_drink]' value='$row[price]' pattern='[0-9]+(\.[0-9]{2})?' title='Enter a valid price (e.g., 10.99)'></td>";
          echo "<td><input type='text' id='amount_$row[id_drink]' value='$row[amount]' pattern='[0-9]+' title='Enter a valid quantity (e.g., 10)'></td>";
          echo "<td><button onclick='updateDrink($row[id_drink])'>Edit</button></td>";
          echo "</tr>";
        }
        $conn->close();
        ?>
      </table>
    </section>
  </main>

  <script>
    function updateDrink(id) {
      const newName = document.getElementById(`name_${id}`).value;
      const newPrice = document.getElementById(`price_${id}`).value;
      const newAmount = document.getElementById(`amount_${id}`).value;

      // Adicione validação no lado do cliente, se necessário

      $.ajax({
        type: "POST",
        url: "update_handler.php",
        data: { id: id, newName: newName, newPrice: newPrice, newAmount: newAmount },
        success: function(response) {
          console.log(response);
        }
      });
    }
  </script>
</body>
</center>
</html>

