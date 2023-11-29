<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancelamento de Reservas</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
    <section>
      <form action="" method="POST">
      <h2>Cancellation of reservations</h2>
        <label for="data_cancelamento">Cancellation date:</label>
        <input type="date" id="data_cancelamento" name="data_cancelamento" style="margin: 35px;" required>
        <input type="submit" value="Buscar Reservas" style="margin-top: 16px;" >
      <div id="reserva-info" style="margin-top: 44px;" >
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $data_cancelamento = $_POST["data_cancelamento"];
              
                  $servername = "mysql-server";
	          $username = "root";
	          $password = "lritzke";
    	          $database = "restaurant_registration";

	          $conn = new mysqli($servername, $username, $password, $database);

		if (isset($data_cancelamento)) {
    $sql = "SELECT * FROM system_reservations WHERE day = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data_cancelamento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Reservations for the day $data_cancelamento:</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Customer</th>";
        echo "<th>Table number</th>";
        echo "<th>Enter time</th>";
        echo "<th>Leave time</th>";
        echo "<th>Cancel</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["customer"] . "</td>";
            echo "<td>" . $row["table_number"] . "</td>";
            echo "<td>" . $row["enter_time"] . "</td>";
            echo "<td>" . $row["leave_time"] . "</td>";
            echo "<td><button class='cancelButton' data-id='" . $row["id_reservation"] . "'>Cancel reservation</button></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Não foram encontradas reservas para o dia $data_cancelamento.";
    }

              } elseif (isset($_POST["id_reservation"])) {
                  $id_reserva = $_POST["id_reservation"];
                  
                  $servername = "mysql-server";
                  $username = "root";
                  $password = "lritzke";
                  $database = "restaurant_registration";

                  $conn = new mysqli($servername, $username, $password, $database);

                  $sql = "DELETE FROM system_reservations WHERE id_reservation = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $id_reserva);
                  if ($stmt->execute()) {
                      echo "Reservation successfully canceled.";
                  } else {
                      echo "Error canceling reservation";
                  }
              }

              $conn->close();
          }
        ?>
      </div>
    </section>
  </main>
  <script>
    var cancelConfirmation = function(idReservation) {
      var username = prompt("Do you want to cancel this reservation? If yes, answer: Yes");

      if (username === "Yes") {
        $.post("", { id_reservation: idReservation }, function(data) {
          if (data === "Reservation successfully canceled.") {
            alert("Reservation successfully canceled.");
            location.reload();
          } else {
            alert("Reservation successfully canceled.");
            location.reload();
          }
        });
      } else {
        alert("Incorrect username or password. Unauthorized cancellation.");
      }
    };

    $(document).ready(function () {
      $(".cancelButton").click(function () {
        var idReservation = $(this).data("id");
        cancelConfirmation(idReservation);
      });
    });
  </script>
</body>
</html>
