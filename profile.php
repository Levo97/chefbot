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
    $x=0;

    $uid=$_SESSION["id"];
    $sql4 = "SELECT hozzaszolasok_moderate,  felhasznalok_moderate  FROM jogok where felhasznalok_id=$uid";
    $result = $conn->query($sql4);
    if ($result->num_rows > 0 ) {
        while ($row = $result->fetch_assoc()) {
            if($row["hozzaszolasok_moderate"]==1){
                $x=1;
            } elseif ($row["felhasznalok_moderate"]==1) {
                $x=2;

            }
        }
        }
        if (!isset($_GET['id']) || $x>0 ) {
            $sql4 = "SELECT ki,mit,recept.neve as hol, hozzaszolasok.id from hozzaszolasok,recept where recept.id=hozzaszolasok.recept_id and ki=$id ORDER by id desc ";
            $result = $conn->query($sql4);

            if ($result->num_rows > 0 ) {  echo "      <div class='doboz ' >
          <h3>Moderált hozzászólások:</h3>
<div class='table-wrapper-scroll-y my-custom-scrollbar'>

          ";

                while ($row = $result->fetch_assoc()) {
                    echo "
  
        <div class='mssgBox' >
         <h3>" . $row["hol"] . "</h3>
          <h5>" . $row["mit"] . "</h5>
          "; if ($x==1){ $ki=$row["ki"]; $hozzaszolas_id=$row["id"]; echo "<form method='post' action='profile.php?id=$ki'> <button name=\"cloes_ticket\" type=\"submit\" value='$hozzaszolas_id' class=\"btn btn-primary\"> vétózás</button>
      <input type='hidden' name='felhasznalo' id='felhasznalo' value='" . $row["ki"] . "'>

</form> ";} echo"
        </div>
       
        
        ";
                }
            }
            echo " </div></div>";


            if (isset($_POST["cloes_ticket"])){
                $hozzaszolas_id2=$_POST["cloes_ticket"];
                $felhasznalo=$_POST["felhasznalo"];
                $sq2 = "update hozzaszolasok SET moderated=0 where id='$hozzaszolas_id2'";
                $result = $conn->query($sq2);

                $sq2 = "SELECT id FROM uzenetek_ticket where tema_id=1 and closed=0 and felhasznalo_id='$felhasznalo'";
                $result = $conn->query($sq2);
                if ($result->num_rows > 0 ) {
                    while ($row = $result->fetch_assoc()) {
                        $ticket_id=$row["id"];
                        $sq3 = "update uzenetek_ticket SET closed=1 where id='$ticket_id'";
                        $result2 = $conn->query($sq3);
                    }

                    $sq4 = "SELECT id FROM uzenetek_ticket where tema_id=0 and closed=0 and felhasznalo_id='$felhasznalo'";
                    $result3 = $conn->query($sq4);
                    if ($result3->num_rows > 0 ) {

                        while ($row2 = $result3->fetch_assoc()) {
                            $ticket_id2=$row2["id"];
                            $ido=date("Y-m-d H:i:s");
                            $rm = "insert into uzenetek (ticket_id,user_boolean,uzenet,mikor,visszavonhato) values ($ticket_id2,0,'A moderált hozzászólásodat visszaállítottuk.', '$ido',0)";
                            $result4 = $conn->query($rm);


                        }
                        }
                }
            }
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