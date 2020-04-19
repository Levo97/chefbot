<?php
include_once 'include/menu.php'
?>
<?php
$hidden_recept=1;
$recept_szerkesztes=0;
$hozzaszolasok_szerkesztes=0;
if (isset($_SESSION['id'])){

    $uid=$_SESSION['id'];

    $sql="SELECT * FROM jogok where felhasznalok_id= $uid";
    $result = $conn->query($sql);
    $jogom=array();


    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $jogom= array_merge($jogom, array('hozzaszolasok'  =>$row["hozzaszolasok_moderate"], 'alapanyagok' =>$row["alapanyagok_moderate"], 'felhasznalok' =>$row["felhasznalok_moderate"],'kategoriak' =>$row["kategoriak_moderate"],'mertekegyseg' =>$row["mertekegyseg_moderate"],'recept' =>$row["recept_moderate"], 'rights' =>$row["rights_manage"]));

        }
        $recept_szerkesztes=$jogom['recept'];
        $hozzaszolasok_szerkesztes=$jogom['hozzaszolasok'];
    }





}

$id=$_GET['id'];
$sql = "SELECT recept.id,recept.szerzo_id,felhasznalok.username as felhasznalo,recept.neve,recept.leiras,recept.mikor,recept.hidden as hidden, TRUNCATE(sum((energia*mennyiseg)),2)as energia,TRUNCATE(sum((feherje*mennyiseg)),2)as feherje,TRUNCATE(sum((szenhidrat*mennyiseg)),2)as szenhidrat ,TRUNCATE(sum((zsir*mennyiseg)),2)as zsir,missing_data as egyeb FROM hozzavalok, alapanyagok, recept,felhasznalok where recept_id=$id and alapanyagok.id=alapanyag_id and recept_id=recept.id and felhasznalok.id=recept.szerzo_id";
$result = $conn->query($sql);
$sql = "select alapanyagok.neve as alapanyag,hozzavalok.mennyiseg as mennyi, mertekegyseg.id as mertekegyseg_id,mertekegyseg.neve as mertekegyseg_neve from hozzavalok, alapanyagok, alapanyagok_meretekegyseg,mertekegyseg where alapanyag_id=alapanyagok.id and recept_id=$id and alapanyagok_meretekegyseg.alapanyagok_id=alapanyagok.id and mertekegyseg.id=alapanyagok_meretekegyseg.mertekegyseg_id ";
$hozzavalok = $conn->query($sql);

?>
<?php
while($row = $result->fetch_assoc()) {
    $hidden_recept=$row["hidden"];
    if (($hidden_recept==0 || $recept_szerkesztes==1 )&& $row["id"]>0 ){
        echo "<div class='doboz'>
                    <div class='row'>
                        <div class='col-sm-7'>
                            <h1>".$row["neve"]."</h1>";

        if(isset($_SESSION["user"]) && $hidden_recept==0){
            echo"<div style='display: table; padding-bottom: 2%'>
                            <div style='display: table-cell;'>";
            echo "<form method='post' action='";
            echo  "like.php'>
                                <input type='hidden' name='id' id='id' value='".$row["id"]." '>
                                <input type='hidden' name='pont' id='pont' value=1>
                                <button type='submit' class='btn btn-default btn-sm'>
                                <span class='glyphicon glyphicon-thumbs-up'></span>Finom</button>
                            </form>
                            </div>
                            <div style='display: table-cell;'>
                            <form method='post' action='";
            echo  "like.php'>
                                <input type='hidden' name='id' id='id' value='".$row["id"]."'>
                                <input type='hidden' name='pont' id='pont' value=-1>
                                <button type='submit' class='btn btn-default btn-sm'>
                                <span class='glyphicon glyphicon-thumbs-down'></span>Nem finom</button>
                            </form>";
            echo"</div></div>";
        }if ($recept_szerkesztes==1){
echo"   <form method='post' action='szerkesztes.php'><button id=\"recept_az\" name=\"recept_az\" type=\"submit\" class=\"btn btn-primary\" value='".$row["id"]." '>Szerkesztés</button></form>";
echo "    
    <form method='post' action='kezeles.php'>
      <input type=\"hidden\" id=\"recept_az\" name=\"recept_az\" value='".$row["id"]."'>
            <input type=\"hidden\" id=\"recept_status\" name=\"recept_status\" value='".$hidden_recept."'>

";

if ($hidden_recept==0){echo"<button type=\"submit\" name='etlap_modositas' id='etlap_modositas' class=\"btn btn-primary\">Leveszem az étlapról</button></form>";}
            if ($hidden_recept==1){echo"<button type=\"submit\" name='etlap_modositas' id='etlap_modositas' class=\"btn btn-primary\">Felteszem az étlapra</button></form>";}

        }

        echo"
                            <p><ol>".$row["leiras"]."</ol></p>
                            <table class=\"table table-striped\">
    <thead>
      <tr>
        <th>Energia</th>
        <th>Fehérje</th>
        <th>Zsír</th>
        <th>Szénhidrát</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>".$row["energia"]."</td>
        <td>".$row["feherje"]."</td>
        <td>".$row["zsir"]."</td>
        <td>".$row["szenhidrat"]."</td>
      </tr>
    </tbody>
  </table>
  
  
        <table class=\"table table-striped\">
    <thead>
      <tr>
        <th>Hozzávaló</th>
        <th>Mennyiség</th>
      </tr>
    </thead>
    <tbody>
     ";

        if ($hozzavalok->num_rows > 0) {
            while($row2 = $hozzavalok->fetch_assoc()) {

                echo"

       <tr>
        <td>".$row2["alapanyag"]."</td>
        <td>".$row2["mennyi"]."  ".$row2["mertekegyseg_neve"]."</td>
      </tr>";

            }}



        echo"    
    </tbody>
  </table>";



    if ($recept_szerkesztes==1 && $row["egyeb"]!=null ){echo"
<div class='mssgBox'>
<h4>egyéb nem rögzíthető adatok: </h4>

        <p>".$row["egyeb"]." </p> 
 </div>

        ";}echo"
            </div>";
        echo "<div class='col-sm-5'>
                            <img class='img-fluid' src='include/img/".$row["id"].".jpg'   style='border:5px solid black;'>
                        </div>
                   <h4 style='float:right'> <a href='profile.php?id=".$row["szerzo_id"]."'>" . $row['felhasznalo'] ."</a> - ".$row["mikor"]."</h4>
                    </div>
            </div>";




    }else{ $hidden_recept=-1;
        echo"<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... úgy néz ki ez a recept még nem forrott ki</font></h1></div>
    ";
    }


}

if ($hidden_recept==0){
?>
<div class="doboz" style="padding-top: 2%;">
    <div style=" height:300px; overflow-y: auto;">
        <?php
        if (isset($_SESSION["id"])) {
            $sessId = $_SESSION["id"];

            $sql0 = "SELECT felhasznalok.tiltott as tiltott ,hozzaszolasok_moderate FROM jogok,felhasznalok where felhasznalok_id=felhasznalok.id and id = $sessId";
            $result = $conn->query($sql0);
            $current_user = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $current_user = array_merge($current_user, array('tiltott' => $row["tiltott"], 'jog' => $row["hozzaszolasok_moderate"]));
                }

            }

            if (isset($_POST['text'])) {


                if ($current_user['tiltott'] != 1) {

                    $sql3 = "INSERT INTO hozzaszolasok (recept_id,ki,mit) values ($id,$sessId,'" . $_POST['text'] . "')";
                    $conn->query($sql3);
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("A felhasználódnál jelenleg le van tiltva a ez a funkció..")';
                    echo '</script>';
                }
            }

            if (isset($_POST['felhasznalo'])) {
                $rm = "UPDATE hozzaszolasok set moderated=1 where id= '" . $_POST['felhasznalo'] . "'";

                $result = $conn->query($rm);
            }
        }
        $sql2 = "SELECT mit, username,hozzaszolasok.id as hozzaszolasok_id FROM hozzaszolasok, felhasznalok where $id=hozzaszolasok.recept_id AND hozzaszolasok.ki=felhasznalok.id and moderated=0 ";

        $result = $conn->query($sql2);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                echo "
<div class='mssgBox'>
<h3> ".$row["username"]."</h3>
    <p>".$row["mit"]."</p>";
                if (isset($_SESSION["id"]) && $current_user['jog']==1){
                    echo"     
    <form method = 'post' id = 'rm' action ='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$id'>
     <button type = 'submit' class='btn btn-success'  id='felhasznalo' name='felhasznalo' value=".$row["hozzaszolasok_id"].">Törlés</button></form>";
                }
                echo"
    </div>
";

            }}

        ?>
    </div>
    <?php
    if(isset($_SESSION["id"])) {
        echo "<form method = 'post' id = 'hozzaId' action ='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$id'>
    <div class='form-group align-center' style = 'margin-left: 10%; margin-right: 10%;' >
        <label for='comment' > Szólj hozzá:</label >
        <textarea class='form-control' rows = '5' id = 'text' name = 'text' ></textarea >
        <button type = 'submit' class='btn btn-success' > Hozzászólás</button >
    </div >
</form >


</div>
</div>
</div>



</body>
</html>

";
    }}
    ?>
