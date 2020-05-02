<?php
include_once 'include/menu.php';
if (isset($_SESSION["id"])){

?>
<?php $view = 0;

$id = $_SESSION["id"];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $view = 1;
}


$sql = "SELECT SUM(pontozas.pont) AS tmp FROM pontozas,recept where recept.szerzo_id=$id and recept.hidden=0 and  pontozas.mit=recept.id";

$sql2 = "SELECT COUNT(recept.id) AS tmp2 from recept where recept.hidden=0 and recept.szerzo_id=$id";


$sql0 = "SELECT * FROM felhasznalok where id= $id";
$result = $conn->query($sql0);
$kert_felhasznalo = array();


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $kert_felhasznalo = array_merge($kert_felhasznalo, array('username' => $row["username"]));
    }

}
$rang = $conn->query($sql);
$receptek = $conn->query($sql2);
$pont = 0;
$titulus = "";
$kep = "";
$darab = 0;
?>
<div class="doboz" >
    <div class="kozep">
        <?php
        $nev = $kert_felhasznalo['username'];
        echo "<h1>Üdv <mark class='blue'>" . $nev . "</mark> konyhájában!</h1>";
        if ($rang->num_rows > 0) {
            while ($row = $rang->fetch_assoc()) {
                if ($row["tmp"] > 0 && $row["tmp"] != null) {
                    $pont = $row["tmp"];
                }
            }
        } else {
            echo "0 results";
        }
        if ($receptek->num_rows > 0) {
            while ($row = $receptek->fetch_assoc()) {
                if ($row["tmp2"] > 0 && $row["tmp2"] != null) {
                    $darab = $row["tmp2"];
                }
            }
        } else {
            echo "0 results";
        }

        if ($pont < 2) {
            $titulus = "mosogatófiú";
            $kep = "mosogat.png";
        } else if ($pont >= 2 && $pont < 3) {
            $titulus = "pincér";
            $kep = "waiter.png";
        } else {
            $titulus = "chef";
            $kep = "chef.png";
        }

        echo "<img src='include/img/" . $kep . "'>";

        echo "<h4><mark class='blue'>" . $nev . "</mark> egy " . $pont . " pontos " . $titulus . " </h4>
        <h4>$darab recepttel.</h4>";
        ?>
    </div>
</div>
    <?php
    $sql3 = "SELECT * FROM recept WHERE szerzo_id=$id and recept.hidden!=1";
    $result = $conn->query($sql3);

    ?>


        <?php if ($result->num_rows > 0) {
            echo "   <div class=\"doboz\">
 <h3>Receptek:</h3>
    <div style=\" height:200px; overflow-y: auto;\">";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='doboz '>
                        <div class='row'>
                        <a href='recept.php?id=" . $row["id"] . "'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'>
                            </div>
                            <div class='col-sm-10'>
                                <h1>" . $row["neve"] . "</h1>
                                <h5>" . $row["mikor"] . "</h5>
                            </div>
                            </a>
                        </div>
                        </div>";
            }
        echo "</div></div>";

    }

        if (!isset($_GET['id'])) {
            $sql4 = "SELECT recept.neve as hol,mit FROM hozzaszolasok,recept where ki=$id";
            $result = $conn->query($sql4);

            if ($result->num_rows > 0 ) {  echo "      <div class='doboz ' >
          <h3>Moderált hozzászólásaid:</h3>
<div class='table-wrapper-scroll-y my-custom-scrollbar'>

          ";

                while ($row = $result->fetch_assoc()) {
                    echo "
  
        <div class='mssgBox' >
         <h3>" . $row["hol"] . "</h3>
          <h5>" . $row["mit"] . "</h5>
        </div>
       
        
        ";
                }
            }
            echo " </div></div>";
        }
        ?>

    </div></div>
    </body>
    </html>
    <?php
}else{
    echo "<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... lehet eltévedtünk</font></h1></div>
    ";
}