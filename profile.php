<?php
include_once 'include/menu.php'
?>
<?php

$id=$_SESSION["id"];
$sql = "SELECT SUM(pontozas.fel) AS tmp FROM pontozas,recept where recept.szerzo_id=$id and pontozas.mit=recept.id";

$sql2 = "SELECT COUNT(recept.id) AS tmp2 from recept where  recept.szerzo_id=$id";

$rang = $conn->query($sql);
$receptek = $conn->query($sql2);
$pont =0;
$titulus="";
$kep="";
$darab=0;
?>
<div class='doboz'>
    <div class="kozep">
<?php
    echo "<h1>Szia ".$_SESSION["user"]."!</h1>";
    if ($rang->num_rows > 0) {
    while($row = $rang->fetch_assoc()) {
        if($row["tmp"]>0 && $row["tmp"]!=null){
            $pont = $row["tmp"];
        }
    }
    } else {
    echo "0 results";
    }
    if ($receptek->num_rows > 0) {
    while($row = $receptek->fetch_assoc()) {
        if($row["tmp2"]>0 && $row["tmp2"]!=null){
            $darab = $row["tmp2"];
        }
    }
    } else {
    echo "0 results";
}

if($pont<2){
    $titulus="mosogatófiú";
    $kep="mosogat.png";
}else if($pont>=2 && $pont<3){
    $titulus="pincér";
    $kep="waiter.png";
}else{
    $titulus="chef";
    $kep="chef.png";
}

echo "<img src='include/img/".$kep."'>";

echo "<h4>Te egy " . $pont. " pontos ".$titulus." vagy</h4>
        <h4>$darab recepttel.</h4>";
?>
    </div>
</div>
<div class="doboz">
    <?php
    $sql3 = "SELECT * FROM recept WHERE szerzo_id=$id";
    $result = $conn->query($sql3);

    ?>
    <h3>Receptjeid:</h3>

    <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='doboz '>
                        <div class='row'>
                        <a href='recept.php?id=".$row["id"]."'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/".$row["id"].".jpg'>
                            </div>
                            <div class='col-sm-10'>
                                <h1>".$row["neve"]."</h1>
                                <h5>".$row["mikor"]."</h5>
                            </div>
                            </a>
                        </div>
                        </div>";
            }
        } else {
            echo "<h3>Még nem töltöttél fel egy receptet sem.</h3>";
        }
        ?>
</div>
</div>
</body>
</html>
