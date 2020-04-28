<?php
include_once 'include/menu.php'; ?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawBasic);



    function drawBasic() {

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'time');
        data.addColumn('number', 'Dogs');
        data.addRows([
            <?php
            $query = "SET lc_time_names = 'hu_HU' ;
SELECT DAYNAME(bejelentkezve) from felhasznalok";

            $exec = mysqli_query($con,$query);
            while($row = mysqli_fetch_array($exec)){

                echo "['".$row['class_name']."',".$row['students']."],";
            }
            ?>
        ]);

        var options = {
            hAxis: {
                title: 'Time'
            },
            vAxis: {
                title: 'Popularity'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    } </script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div"></div>
