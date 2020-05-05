<?php
include_once 'include/menu.php';
if (isset($_SESSION["id"]) && $_SESSION["id"] == 2) {


    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Napok', 'Felhasználó']
                <?php


                $query = "select * from ( SELECT DATE(NOW()) as datum, count(DATE(bejelentkezve))as darab FROM felhasznalok WHERE DATE(NOW()) = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 1 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 1 DAY = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 2 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 2 DAY = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 3 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 3 DAY = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 4 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 4 DAY = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 5 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 5 DAY = DATE(bejelentkezve) UNION SELECT DATE(NOW()) - INTERVAL 6 DAY, count(DATE(bejelentkezve)) FROM felhasznalok WHERE DATE(NOW()) - INTERVAL 6 DAY = DATE(bejelentkezve)) a order by datum";

                $exec = mysqli_query($conn, $query);


                while ($row = mysqli_fetch_array($exec)) {
                    echo ",['" . $row['datum'] . "'," . $row['darab'] . "]";
                }
                ?>
            ]);

            var options = {
                title: 'Az elmúlt hét nap bejelentkezései',
                vAxis: {minValue: 0},
                backgroundColor: '#ced1d8',

            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'line']});
        google.charts.setOnLoadCallback(drawCurveTypes);

        function drawCurveTypes() {
            var data = google.visualization.arrayToDataTable([
                ['Napok', 'Recept']

                <?php

                $query = "select * from (SELECT DATE(NOW()) as datum, count(DATE(mikor)) as darab FROM recept WHERE DATE(NOW()) = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 1 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 1 DAY = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 2 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 2 DAY = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 3 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 3 DAY = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 4 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 4 DAY = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 5 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 5 DAY = DATE(mikor) UNION SELECT DATE(NOW()) - INTERVAL 6 DAY, count(DATE(mikor)) FROM recept WHERE DATE(NOW()) - INTERVAL 6 DAY = DATE(mikor))a order by datum ";


                $exec = mysqli_query($conn, $query);


                while ($row = mysqli_fetch_array($exec)) {
                    echo ",['" . $row['datum'] . "'," . $row['darab'] . "]";
                }
                ?>
            ]);

            var options = {
                title: 'Az elmúlt hét nap új receptei',
                backgroundColor: '#ced1d8',

                series: {
                    1: {curveType: 'function'}
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Kategoria', 'Recept']
                <?php    $query = "SELECT kategoria.neve as neve, COUNT(recept_id) as darab FROM kategoriak, kategoria where kategoriak.kategoria_id=kategoria.id GROUP by kategoria.neve  order by darab desc limit 100  ";


                $exec = mysqli_query($conn, $query);


                while ($row = mysqli_fetch_array($exec)) {
                    echo ",['" . $row['neve'] . "'," . $row['darab'] . "]";
                }
                ?>
            ]);

            var options = {
                title: 'Kategóriák',
                pieHole: 0.4,
                backgroundColor: '#ced1d8',
                is3D: true
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript">
        google.charts.load('current', {'packages': ['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = google.visualization.arrayToDataTable([
                ["Hozzávaló", "Recept"]
                <?php    $query = "SELECT alapanyagok.neve as neve ,COUNT(recept_id) as darab FROM hozzavalok,alapanyagok where alapanyagok.id=hozzavalok.alapanyag_id GROUP by alapanyagok.neve   ";


                $exec = mysqli_query($conn, $query);


                while ($row = mysqli_fetch_array($exec)) {
                    echo ",['" . $row['neve'] . "'," . $row['darab'] . "]";
                }

                ?>
            ]);

            var options = {
                legend: {position: 'none'},
                backgroundColor: '#ced1d8',
                is3D: true,

                bar: {groupWidth: "90%"}
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div4'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        };
    </script>

    <div id="chart_div3"
         style="width: 100%; height: 500px; display:inline-block; border-style: solid;  border-width: 7px; border-color: #818181;"></div>

    <div id="chart_div"
         style="width: 100%; height: 500px; display:inline-block; border-style: solid;  border-width: 7px; border-color: #818181;"></div>

    <div id="chart_div2"
         style="width: 100%; height: 500px; display:inline-block; border-style: solid;  border-width: 7px; border-color: #818181;"></div>

    <div id="chart_div4"
         style="width: 100%; height: 500px; display:inline-block; border-style: solid;  border-width: 7px; border-color: #818181;"></div>

    <?php
} else {

    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... lehet eltévedtünk</font></h1></div></div>
    ";
}
$conn->close();