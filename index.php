<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu_Waiter</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .table-container {
      width: 30%;
      float: left;
      margin-bottom: 20px;
      overflow: hidden;
    }

    table,
    th,
    td {
      border: 1px solid black;
      border-radius: 10px;
      width: 100%;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      background-color: white;
    }

    .quantity-input {
      width: 40px;
    }
  </style>
</head>

<body>
  <div id="background-paragraph"></div>
  <section id="menu">
    <header>
      <h1>Cleiton Restaurant</h1>
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
        </ul>
      </nav>
    </header>
  </section>

  <!-- Rotations and Drinks -->
  <div class="table-container">
    <h2>Menu</h2>
    <?php
    $servername = "mysql-server";
    $username = "root";
    $password = "lritzke";
    $database = "restaurant_registration";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $rotationsResult = $conn->query("SELECT name_buffet, price FROM pizza_buffet;");

    if ($rotationsResult->num_rows > 0) {
      echo "<table>";
      echo "<thead><tr><th>Name</th><th>Price</th><th>Amount</th></tr></thead><tbody>";
      while ($row = $rotationsResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['name_buffet']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><input type='number' min='0' value='0' class='quantity-input'></td>";
        echo "</tr>";
      }
      echo "</tbody></table>";
    }

    $conn->close();
    ?>
  </div>

  <div class="table-container">
    <h2>Drinks</h2>
    <?php
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $drinksResult = $conn->query("SELECT name, price, amount FROM drinks");

    if ($drinksResult->num_rows > 0) {
      echo "<table>";
      echo "<thead><tr><th>Name</th><th>Price</th><th>Amount</th></tr></thead><tbody>";
      while ($row = $drinksResult->fetch_assoc()) {
        echo "<tr data-amount='{$row['amount']}'>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><input type='number' min='0' value='0' class='quantity-input'></td>";
        echo "</tr>";
      }
      echo "</tbody></table>";
    }

    $conn->close();
    ?>
  </div>

  <!-- Close Order Button -->
  <button onclick="toggleOrderSummary()" style="margin-top: 346px; margin-left: -657px; padding: 20px;">Close Order</button>

  <!-- Verificar CPF Input e Botão -->
  <div id="verify-cpf-container" style="display: none;">
    <label for="verify-cpf">Enter CPF to Verify:</label>
    <input type="text" id="verify-cpf" placeholder="123.456.789-01" style="width: 212px;">
    <button onclick="verifyCPF()">Verify CPF</button>
  </div>

  <!-- Order Summary -->
  <div id="order-summary" style="display: none; margin-top: -420px;">
    <h2>Order Summary</h2>
    <p id="total-price" style="color: white;"></p>
    <form id="payment-form" style="display: none;">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" required>
      <label for="birthdate">Birthdate:</label>
      <input type="date" id="birthdate" required>
      <label for="cpf">CPF:</label>
      <input type="text" id="cpf" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="123.456.789-01">
      <button type="button" onclick="payOrder()">Pay Order</button>
    </form>
  </div>

  <script>
    function toggleOrderSummary() {
      var quantities = document.getElementsByClassName('quantity-input');
      var isOrderEmpty = true;

      for (var i = 0; i < quantities.length; i++) {
        if (parseInt(quantities[i].value) > 0) {
          isOrderEmpty = false;
          break;
        }
      }

      if (isOrderEmpty) {
        alert("Select at least one item before placing your order.");
        return;
      }

      document.querySelectorAll('.table-container').forEach(function (element) {
        element.style.display = 'none';
      });

      // Exibir o contêiner de verificação de CPF
      document.getElementById('verify-cpf-container').style.display = 'block';

      var orderSummary = document.getElementById('order-summary');
      if (orderSummary.style.display === 'none') {
        orderSummary.style.display = 'block';
      } else {
        orderSummary.style.display = 'none';
      }

      calculateTotal();
    }

    function calculateTotal() {
      var quantities = document.getElementsByClassName('quantity-input');
      var total = 0;

      for (var i = 0; i < quantities.length; i++) {
        var quantity = parseInt(quantities[i].value);
        var price = parseFloat(quantities[i].parentNode.parentNode.getElementsByTagName('td')[1].innerText);
        total += quantity * price;
      }

      document.getElementById('total-price').innerText = 'Total Price: $' + total.toFixed(2);
    }

    var cpfExists = false;

    function verifyCPF() {
      var cpfToVerify = document.getElementById('verify-cpf').value;

      if (cpfToVerify === '') {
        alert('Please enter a valid CPF.');
        return;
      }

      $.ajax({
        method: 'POST',
        url: 'verify_cpf.php',
        data: { cpf: cpfToVerify },
        success: function (response) {
          console.log(response); // Exibir a resposta no console
          var data = JSON.parse(response);

          if (data.exists) {
            document.getElementById('fullname').value = data.fullname;
            document.getElementById('birthdate').value = data.birthdate;
            document.getElementById('cpf').value = cpfToVerify;

            cpfExists = true;
          } else {
            document.getElementById('fullname').value = '';
            document.getElementById('birthdate').value = '';
            document.getElementById('cpf').value = cpfToVerify;

            cpfExists = false;
          }

          document.getElementById('verify-cpf-container').style.display = 'none';
          document.getElementById('payment-form').style.display = 'block';
        },
        error: function (xhr, status, error) {
          console.error('Error verifying CPF:', error);
          alert('An error occurred while verifying the CPF. Please check the console for details and try again later.');
        }
      });
    }
  function payOrder() {
    var fullname = document.getElementById('fullname').value;
    var birthdate = document.getElementById('birthdate').value;
    var cpf = document.getElementById('cpf').value;
    var quantities = document.getElementsByClassName('quantity-input');
    var itemsBought = [];

    for (var i = 0; i < quantities.length; i++) {
      var quantity = parseInt(quantities[i].value);
      if (quantity > 0) {
        var itemName = quantities[i].parentNode.parentNode.getElementsByTagName('td')[0].innerText;
        itemsBought.push({ name: itemName, quantity: quantity });
      }
    }

    $.ajax({
      method: 'POST',
      url: 'process_order.php',
      data: {
        fullname: fullname,
        birthdate: birthdate,
        cpf: cpf,
        itemsBought: JSON.stringify(itemsBought)
      },
      success: function (response) {
        console.log(response); // Exibir a resposta no console

        // Adicionar o código PHP adicional aqui
        $.ajax({
          method: 'POST',
          url: 'adicionar_cliente.php',
          data: { cpf: cpf, fullname: fullname, birthdate: birthdate },
          success: function (response) {
            var data = JSON.parse(response);

            if (!data.success) {
              console.error(data.message);
              alert('An error occurred while adding customer information. Please check the console for details.');
            }
          },
          error: function (error) {
            console.error('Error adding customer information:', error);
            alert('An error occurred while adding customer information. Please try again later.');
          }
        });

        alert('Order processed successfully!');
        location.reload();
      },
      error: function (error) {
        console.error('Error processing order:', error);
        alert('An error occurred while processing the order. Please try again later.');
      }
    });
  }
  </script>
</body>

</html>

