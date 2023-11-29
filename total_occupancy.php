<!DOCTYPE html>
<html lang="en">
<head>
    <title>Percentages</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div id="background-paragraph"></div>
<section id="menu">
    <header>
        <h1>Cleiton Restaurant</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="shopping.php">Reservations</a></li>
		<li><a href="total_occupancy.php">Total occupancy</a></li>
            </ul>
        </nav>
    </header>
</section>
<div class="tabela-container"  style="background-color: white;margin-left: 563px;margin-top: 0px;border-radius: 10px;position: fixed;width: 561px;" >
<p class="tabela-title">Capacity for the Next 5 Days</p>
    <table class="tabela">
        <thead>
            <tr>
                <th>Date</th>
                <th>Occupancy</th>
            </tr>
        </thead>
        <tbody id="tabela-body">
            <!-- Aqui serão adicionadas as linhas da tabela dinamicamente -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        carregarTabelaLotacao();
    });

    function carregarTabelaLotacao() {
        var tabelaTitle = document.querySelector('.tabela-title');
        var tabelaBody = document.getElementById('tabela-body');
        var hoje = new Date();
        var dias = ['today', 'tomorrow', 'day_after_tomorrow', 'fourth_day', 'fifth_day'];

        tabelaTitle.innerHTML = "Capacity for the Next 5 Days";

        for (var i = 0; i < dias.length; i++) {
            var data = new Date(hoje);
            data.setDate(hoje.getDate() + i);

            var formattedDate = data.toISOString().split('T')[0];
            var percentage = obterLotacaoDoBanco(formattedDate);

            // Adiciona uma nova linha à tabela
            var newRow = tabelaBody.insertRow();
            var cellDate = newRow.insertCell(0);
            var cellPercentage = newRow.insertCell(1);

            cellDate.innerHTML = formattedDate;
            cellPercentage.innerHTML = percentage + '%';
        }
    }

    function obterLotacaoDoBanco(data) {
        var xhr = new XMLHttpRequest();
        var percentage = 0;

        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                percentage = parseInt(this.responseText);
            }
        };

        xhr.open("GET", "obter_lotacao.php?data=" + data, false);
        xhr.send();

        return percentage;
    }
</script>

<div class="percentual" style="background-color: white;width: 446px;padding: 19px;border-radius: 10px;margin-left: 43px;text-align: center;"  >
<label for="calendario">Choose the date</label>
<input type="date" id="calendario" name="calendario" style="width: 357px;" required onchange="validarData()" >
<br>
<button style="width: 381px;" onclick="verificarLotação()">Verify</button>

<script>
function validarData() {
    var calendario = document.getElementById('calendario').value;
    var hoje = new Date(); // Pega a data atual
    var calendarioObj = new Date(calendario);
    var meiaNoiteHoje = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
    if (calendarioObj < meiaNoiteHoje) {
        document.getElementById('calendario').valueAsDate = meiaNoiteHoje;
    }
}
</script>
<div id="percentual-container" style="display: none;">
    <div id="percentual-content" class="white-background">
        <div id="lotacao-bar-container" style="border: 1px solid black; box-sizing: border-box;border-radius: 5px;  " >
            <div id="lotacao-bar"></div>
        </div>
    </div>
            <p id="lotacao-text">Total occupancy: 0%</p>
</div>
</div>
<script>
    function verificarLotação() {
        var selectedDate = document.getElementById('calendario').value;

        if (selectedDate) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var lotacao = parseInt(this.responseText);
                    exibirLotação(lotacao);
                }
            };
            xhr.open("GET", "obter_lotacao.php?data=" + selectedDate, true);
            xhr.send();
        } else {
            alert("Please choose the day for search.");
        }
    }

function exibirLotação(percentage) {
    var percentualContainer = document.getElementById('percentual-container');
    var progressBar = document.getElementById('lotacao-bar');
    var lotacaoText = document.getElementById('lotacao-text');

    progressBar.style.width = percentage + "%";
    lotacaoText.innerText = "Lotation on the day: " + percentage.toFixed(1) + "%";

    // Exibe a div do percentual
    percentualContainer.style.display = 'block';
}


</script>




<?php
    $servername = "mysql-server";
    $username = "root";
    $password = "lritzke";
    $database = "restaurant_registration";

    $conn = new mysqli($servername, $username, $password, $database);
?>
</body>
</html>
