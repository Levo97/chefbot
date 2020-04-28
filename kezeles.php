<?php
include_once 'include/menu.php';
if (isset($_SESSION["id"])){

    echo "<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css\">
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css\"/>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js\"></script>";

$uid = $_SESSION['id'];

$stmt = $conn->prepare('SELECT * FROM jogok where felhasznalok_id= ?');
$stmt->bind_param('s', $uid);
$stmt->execute();
$result = $stmt->get_result();
$jogom = array();


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $jogom = array_merge($jogom, array('hozzaszolasok' => $row["hozzaszolasok_moderate"], 'alapanyagok' => $row["alapanyagok_moderate"], 'felhasznalok' => $row["felhasznalok_moderate"], 'kategoriak' => $row["kategoriak_moderate"], 'recept' => $row["recept_moderate"], 'rights' => $row["rights_manage"]));
    }

}
$stmt = $conn->prepare('SELECT * FROM felhasznalok where id!=2 order by username');
$stmt->execute();
$result = $stmt->get_result();
$felhasznalok = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        array_push($felhasznalok, array('id' => $row["id"], 'username' => $row["username"], 'tiltott' => $row["tiltott"], 'bejelentkezve' => $row["bejelentkezve"]));
    }

}
$stmt = $conn->prepare('SELECT * FROM jogok');
$stmt->execute();
$result = $stmt->get_result();
$jogok = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        array_push($jogok, array('felhasznalok' => $row["felhasznalok_id"], 'hozzaszolasok' => $row["hozzaszolasok_moderate"], 'alapanyagok' => $row["alapanyagok_moderate"], 'felhasznalok' => $row["felhasznalok_moderate"], 'kategoriak' => $row["kategoriak_moderate"], 'recept' => $row["recept_moderate"], 'rights' => $row["rights_manage"]));
    }

}

$stmt = $conn->prepare('SELECT * FROM mertekegyseg');
$stmt->execute();
$result = $stmt->get_result();

$mertekegysegek = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        array_push($mertekegysegek, array('id' => $row["id"], 'neve' => $row["neve"]));
    }

}




if ($jogom['rights'] == 1) {
    echo "<div class='doboz '>
<p> <ins><b>A kiválasztott felhasználókhoz itt lehet jogokat hozzárendelni.</b> </ins></p>
<form method='post' action='kezeles.php'>
<label for=\"users\">Felhasználó:</label>
<select data-live-search=\"true\" class=\"selectpicker\" id=\"users\" name=\"users\" required>
    <option disabled selected value> Válassz...</option>

";
    foreach ($felhasznalok as $felhasznalo) {
        echo "  <option value='" . $felhasznalo['id'] . "'>" . $felhasznalo['username'] . "</option>";
    }
    echo "
</select>

<label for=\"rights\">Jogok:</label>
<select id=\"rights\" name=\"rights\" class=\"selectpicker\" required>
";

    echo " 
     <option disabled selected value> Válassz...</option>

  <option value='hozzaszolasok_moderate'>Hozzászólásk moderálása</option>
   <option value='alapanyagok_moderate'>Alapanyagok hozzáadása</option>
   <option value='felhasznalok_moderate'>Felhasználók moderálása</option>
   <option value='kategoriak_moderate'>Kategorizálási jog</option>
   <option value='recept_moderate'>Recept szerkesztő</option>
   <option value='rights_manage'>Jogok kezelése</option>
    
</select>
<input type='submit' value='Jog megadása'>
</form>
";
    if (isset($_POST['users'])) {


        $sql = "SELECT IF ( EXISTS (SELECT * FROM jogok WHERE felhasznalok_id=" . $_POST["users"] . ") , 1, 0) as valid ";
        $result = $conn->query($sql);


        $letezik = 2;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $letezik = $row['valid'];
            }
        }

        if ($letezik == 1) {

            $sql = "SELECT " . $_POST["rights"] . " as boolean from jogok  where felhasznalok_id=" . $_POST["users"] . "  ";
            $result = $conn->query($sql);
            $jelenlegi = 2;
            while ($row = $result->fetch_assoc()) {
                $jelenlegi = $row['boolean'];
            }

            if ($jelenlegi == 0) {
                $sql = "UPDATE jogok  set " . $_POST["rights"] . " =1 where felhasznalok_id=" . $_POST["users"] . "  ";
                $result = $conn->query($sql);
                echo '<script language="javascript">';
                echo 'alert("Sikeresen megadtuk a jogosultságot.")';
                echo '</script>';

            } else {
                echo '<script language="javascript">';
                echo 'alert("Már van ilyen joga")';
                echo '</script>';
            }

        } else if ($letezik == 0) {
            $sql = "Insert into jogok (felhasznalok_id, " . $_POST["rights"] . " )  values (" . $_POST["users"] . ",1)";
            $result = $conn->query($sql);

            echo '<script language="javascript">';
            echo 'alert("Sikeresen megadtuk a jogosultságot.")';
            echo '</script>';


        }
    }

    echo "
</div>";


    echo "<div class='doboz '>
<p> <ins><b>A kiválasztott felhasználótól itt lehet jogot elvenni.</b> </ins></p>
<form method='post' action='kezeles.php'>
<label for=\"users2\">Felhasználó:</label>
<select id=\"users2\" name=\"users2\" data-live-search=\"true\" class=\"selectpicker\" required>
    <option disabled selected value> Válassz...</option>

";
    foreach ($felhasznalok as $felhasznalo) {
        echo "  <option value='" . $felhasznalo['id'] . "'>" . $felhasznalo['username'] . "</option>";
    }
    echo "
</select>

<label for=\"rights2\">Jogok:</label>
<select id=\"rights2\" name=\"rights2\" class=\"selectpicker\" required>
";

    echo "  
      <option disabled selected value> Válassz...</option>

  <option value='hozzaszolasok_moderate'>Hozzászólásk moderálása</option>
   <option value='alapanyagok_moderate'>Alapanyagok hozzáadása</option>
   <option value='felhasznalok_moderate'>Felhasználók moderálása</option>
   <option value='kategoriak_moderate'>Kategorizálási jog</option>
   <option value='recept_moderate'>Recept szerkesztő</option>
   <option value='rights_manage'>Jogok kezelése</option>
    
</select>
<input type='submit' value='Jog elvétele'>
</form>
";
    if (isset($_POST['users2'])) {
        $sql = "SELECT IF ( EXISTS (SELECT * FROM jogok WHERE felhasznalok_id=" . $_POST["users2"] . ") , 1, 0) as valid ";
        $result = $conn->query($sql);
        $letezik = 2;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $letezik = $row['valid'];
            }
        }
        if ($letezik == 1) {


            $sql = "SELECT " . $_POST["rights2"] . " as boolean from jogok  where felhasznalok_id=" . $_POST["users2"] . "  ";
            $result = $conn->query($sql);
            $jelenlegi = 2;
            while ($row = $result->fetch_assoc()) {
                $jelenlegi = $row['boolean'];
            }

            if ($jelenlegi==1){
            $sql = "UPDATE jogok  set " . $_POST["rights2"] . " =0 where felhasznalok_id=" . $_POST["users2"] . "  ";
            $result = $conn->query($sql);

            echo '<script language="javascript">';
            echo 'alert("Sikeresen elvettük a jogosultságot.")';
            echo '</script>';}else{ echo '<script language="javascript">';
                echo 'alert("Nincs ilyen joga ennek a felhasználónak")';
                echo '</script>';}

        } else if ($letezik == 0) {

            echo '<script language="javascript">';
            echo 'alert("Nincs ilyen joga ennek a felhasználónak")';
            echo '</script>';


        }
    }


    $sql = "SELECT felhasznalok.username as username, alapanyagok_moderate, hozzaszolasok_moderate,felhasznalok_moderate,kategoriak_moderate,mertekegyseg_moderate,recept_moderate,rights_manage FROM felhasznalok,jogok where jogok.felhasznalok_id=felhasznalok.id and ((alapanyagok_moderate=1) or (hozzaszolasok_moderate=1) or (felhasznalok_moderate=1) or (kategoriak_moderate=1) or (mertekegyseg_moderate=1) or (recept_moderate=1) or (rights_manage=1) )   ";
    $result = $conn->query($sql);
    $kivaltsagosok = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kivaltsagosok, array('felhasznalonev' => $row["username"], 'hozzaszolasok' => $row["hozzaszolasok_moderate"], 'alapanyagok' => $row["alapanyagok_moderate"], 'felhasznalok' => $row["felhasznalok_moderate"], 'kategoriak' => $row["kategoriak_moderate"], 'mertekegyseg' => $row["mertekegyseg_moderate"], 'recept' => $row["recept_moderate"], 'rights' => $row["rights_manage"]));
        }

    }

    echo "
</div>

<div class='doboz '>

<div class='table-wrapper-scroll-y my-custom-scrollbar'>


<table class=\"table table-striped\">
  <tr>
    <th>Felhasználó </th>
    <th>Hozzászólásk moderálása </th>
    <th>Alapanyagok hozzáadása </th>
    <th>Felhasználók moderálása </th>
    <th>Kategorizálási jog </th>
    <th>Recept szerkesztő </th>
    <th>Jogok kezelése </th>
  </tr>
  ";
    foreach ($kivaltsagosok as $kivaltsagos) {
        echo "
  <tr>
    <td>" . $kivaltsagos['felhasznalonev'] . "</td>
    <td>";
        if ($kivaltsagos['hozzaszolasok'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo " </td>
    <td>";
        if ($kivaltsagos['alapanyagok'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo " </td>
    <td>";
        if ($kivaltsagos['felhasznalok'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo "</td>
    <td>";
        if ($kivaltsagos['kategoriak'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo "</td>
    <td>";
        if ($kivaltsagos['recept'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo "</td>
    <td>";
        if ($kivaltsagos['rights'] == 1) {
            echo "<span class=\"glyphicon glyphicon-ok\"></span>";
        } else {
            echo " <span class=\"glyphicon glyphicon-remove\"></span>";
        }
        echo "</td>

  </tr>   ";
    }
    echo "
 
</table>
 </div>
 </div>
 
 

";


}
if ($jogom['felhasznalok'] == 1) {
    echo "<div class='doboz '>
<p><ins><b> A kiválasztott felhasználót itt lehet letiltani.</b> </ins></p>
<form method='post' action='kezeles.php'>
<label for=\"users3\">Felhasználó:</label>
<select id=\"users3\" name=\"users3\"  data-live-search=\"true\" class=\"selectpicker\" required>
    <option disabled selected value> Válassz...</option>

";
    foreach ($felhasznalok as $felhasznalo) {
        echo "  <option value='" . $felhasznalo['id'] . "'>" . $felhasznalo['username'] . "</option>";
    }
    echo "
</select>
<input type='submit' value='Tiltás'>
</form>";

    if (isset($_POST['users3'])) {

        $sql = "SELECT * from felhasznalok where id=" . $_POST["users3"] . " ";
        $result = $conn->query($sql);
        $adatai = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $adatai = array_merge($adatai, array('id' => $row["id"], 'tiltott' => $row["tiltott"]));
            }

        }

        if (($adatai['id'] == $_POST["users3"]) && $adatai['tiltott'] == 0) {
            $sql = "UPDATE felhasznalok  set tiltott =1 where id=" . $_POST["users3"] . "  ";
            $result = $conn->query($sql);

            echo '<script language="javascript">';
            echo 'alert("Sikeresen letiltottuk a felhasználót")';
            echo '</script>';

        } else {

            echo '<script language="javascript">';
            echo 'alert("Ez a felhasználó már le ven tíltva")';
            echo '</script>';


        }
    }


    echo "
</div>";

    echo "<div class='doboz '>
<p> <ins><b>A kiválasztott felhasználó tiltásának visszavonása. </b></ins></p>
<form method='post' action='kezeles.php'>
<label for=\"users4\">Felhasználó:</label>
<select id=\"users4\" name=\"users4\"  data-live-search=\"true\" class=\"selectpicker\" required>
    <option disabled selected value> Válassz...</option>

";
    foreach ($felhasznalok as $felhasznalo) {
        echo "  <option value='" . $felhasznalo['id'] . "'>" . $felhasznalo['username'] . "</option>";
    }
    echo "
</select>
<input type='submit' value='Tiltás feloldása'>
</form>";

    if (isset($_POST['users4'])) {

        $sql = "SELECT * from felhasznalok where id=" . $_POST["users4"] . " ";
        $result = $conn->query($sql);
        $adatai = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $adatai = array_merge($adatai, array('id' => $row["id"], 'tiltott' => $row["tiltott"]));
            }

        }

        if (($adatai['id'] == $_POST["users4"]) && $adatai['tiltott'] == 1) {
            $sql = "UPDATE felhasznalok  set tiltott =NULL where id=" . $_POST["users4"] . "  ";
            $result = $conn->query($sql);

            echo '<script language="javascript">';
            echo 'alert("Sikeresen feloldottuk a tiltást")';
            echo '</script>';

        } else {

            echo '<script language="javascript">';
            echo 'alert("Ez a felhasználó nincs letiltva")';
            echo '</script>';


        }
    }


    echo "
</div>


<div class='doboz '>

<div class='table-wrapper-scroll-y my-custom-scrollbar'>


<table class=\"table table-striped\">
  <tr>
    <th>Felhasználó </th>
    <th>Bejelentkezve </th>
    <th>Tiltott </th>

  </tr>";

    foreach ($felhasznalok as $felhasznalo) {
        $tiltotte = "";
        if ($felhasznalo['tiltott'] != null) {
            $tiltotte = "Igen";


            echo "
        
          <tr>
    <td>" . $felhasznalo['username'] . "</td>
    <td>" . $felhasznalo['bejelentkezve'] . "</td>
    <td>" . $tiltotte . "</td>


  </tr> 
        
    ";
        }
    }
    echo "
</table>
 </div>
 </div>
    ";


}
if ($jogom['alapanyagok'] == 1) {


    echo "<div class='doboz'>
<p> <ins><b>Alapanyag felvitele: </b></ins></p>
    <form method='post' action='kezeles.php'>

    <label for=\"rname\">Neve:</label>
  <input type=\"text\" id=\"alapanyag_neve\" name=\"alapanyag_neve\" required>
  
  <label for=\"fname\">Mértékegysége:</label>
  <select id=\"mertekegyseg\" name=\"mertekegyseg\" class=\"selectpicker\" required>
    <option disabled selected value> Válassz...</option>

  ";
    foreach ($mertekegysegek as $mertekegyseg) {
        echo "  <option value='" . $mertekegyseg['id'] . "'>" . $mertekegyseg['neve'] . "</option>";
    }
    echo "
</select>

</br></br>
<table class=\"table table-striped\">
  <tr>
    <th>Energia értéke ( kcal ) </th>
    <th>Fehérje ( gramm ) </th>
    <th>Zsír ( gramm )</th>
    <th>Szénhidrát ( gramm )</th>
  </tr>
  
  <tr>
    <td><input type=\"number\" class=\"form-control\" id=\"alapanyag_energia\" name=\"alapanyag_energia\"  step=\"0.000001\" required></td>
    <td><input type=\"number\" class=\"form-control\" id=\"alapanyag_feherje\" name=\"alapanyag_feherje\"  step=\"0.000001\" required></td>
    <td><input type=\"number\" class=\"form-control\" id=\"alapanyag_zsir\" name=\"alapanyag_zsir\"  step=\"0.000001\" required></td>
    <td><input type=\"number\" class=\"form-control\" id=\"alapanyag_szenhidrat\" name=\"alapanyag_szenhidrat\"  step=\"0.000001\" required></td>
 </tr></table>

 
 
<input type='submit' value='Hozzáadás'>
    </form></div>
";


    if (isset($_POST["alapanyag_neve"])) {


        $neve = " ";
        $neve = $_POST["alapanyag_neve"];
        $neve = trim($neve);
        $neve = stripslashes($neve);
        $neve = htmlspecialchars($neve);
        $neve = mb_strtolower ($neve, "UTF-8");
        $energia = $_POST["alapanyag_energia"];
        $feherje = $_POST["alapanyag_feherje"];
        $szenhidrat = $_POST["alapanyag_zsir"];
        $zsir = $_POST["alapanyag_szenhidrat"];

        $mertek = $_POST["mertekegyseg"];

        if (strlen($neve) > 2 && $energia >= 0 && $feherje >= 0 && $zsir >= 0 && $szenhidrat >= 0) {
            $sql = "insert into alapanyagok  (neve,energia,feherje,szenhidrat,zsir) values ('$neve',$energia,$feherje,$szenhidrat,$zsir) ";
            $result = $conn->query($sql);

            $stmt = $conn->prepare('SELECT id from alapanyagok where neve= ? ');
            $stmt->bind_param("s", $neve);
            $stmt->execute();
            $result = $stmt->get_result();
            $alapanyag_id = 0;


            if ($result->num_rows > 0) {
                $alapanyag_id = 0;

                while ($row = $result->fetch_assoc()) {
                    $alapanyag_id = $row["id"];
                }


                $sql = "insert into alapanyagok_meretekegyseg  (alapanyagok_id,mertekegyseg_id) values ($alapanyag_id,$mertek) ";
                $result = $conn->query($sql);
                echo '<script language="javascript">';
                echo 'alert("Sikeres alapanyag feltöltés")';
                echo '</script>';


            }


        } else {
            echo '<script language="javascript">';
            echo 'alert("Hibásan megadott adatok!")';
            echo '</script>';
        }

    }

    $stmt = $conn->prepare('SELECT * FROM alapanyagok');
    $stmt->execute();
    $result = $stmt->get_result();
    $alapanyagok = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($alapanyagok, array('neve' => $row["neve"], 'energia' => $row["energia"], 'feherje' => $row["feherje"], 'szenhidrat' => $row["szenhidrat"], 'zsir' => $row["zsir"]));
        }


        echo " <div class='doboz' >
   <p><ins> <b>Alapanyagok: </b></ins></p>
   
<div class='table-wrapper-scroll-y my-custom-scrollbar'>
<table class=\"table table-bordered table-striped mb-0\">
    <thead>
      <tr>
        <th scope=\"col\">Neve</th>
        <th scope=\"col\">energia</th>
        <th scope=\"col\">feherje</th>
        <th scope=\"col\">szenhidrat</th>
        <th scope=\"col\">zsir</th>

      </tr>
    </thead>
    <tbody>  ";
        foreach ($alapanyagok as $alapanyag) {
            echo "<tr>
      <td>" . $alapanyag["neve"] . "</td>
     <td>" . $alapanyag["energia"] . "</td>
     <td>" . $alapanyag["feherje"] . "</td>
     <td>" . $alapanyag["szenhidrat"] . "</td>
     <td>" . $alapanyag["zsir"] . "</td>


      </tr>  ";

        }
        echo " </table> </div> </div>";
    }

}
if ($jogom['recept'] == 1) {

    $stmt = $conn->prepare('SELECT recept.id as id, felhasznalok.username as szerzo, recept.szerzo_id as szerzo_id , recept.neve as neve, recept.mikor as mikor FROM recept,felhasznalok where felhasznalok.id=recept.szerzo_id and hidden!=0 order by mikor');
    $stmt->execute();
    $result = $stmt->get_result();
    $receptek = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($receptek, array('id' => $row["id"], 'szerzo' => $row["szerzo"],'szerzo_id' => $row["szerzo_id"], 'neve' => $row["neve"], 'mikor' => $row["mikor"]));
        }


        echo "  <div class='doboz' >
   <p><ins> <b>Jóváhagyásra váró receptek: </b></ins></p>
<div class='table-wrapper-scroll-y my-custom-scrollbar'>
<table class=\"table table-bordered table-striped mb-0\">
    <thead>
      <tr>
        <th scope=\"col\">Recept</th>
        <th scope=\"col\">Szerző</th>
        <th scope=\"col\">Dátum</th>
      </tr>
    </thead>
    <tbody>";
        foreach ($receptek as $recept) {

            echo "
             <tr>
        <th scope=\"row\"> <a href='recept.php?id=" . $recept["id"] . "'>" . $recept["neve"] . "</a></th>
        <td><a href='profile.php?id=".$recept["szerzo_id"]."'>" . $recept["szerzo"] . "</a></td>
     <td>" . $recept["mikor"] . "</td>
      </tr>  ";


        }
        echo "</table> </div></div>";

    }


    echo "</div>";
}
if ($jogom['kategoriak'] == 1) {

    $stmt = $conn->prepare('SELECT * FROM kategoria');
    $stmt->execute();
    $result = $stmt->get_result();
    $kategoriak = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id' => $row["id"], 'neve' => $row["neve"]));
        }
    }

    echo "  <div class='doboz'>
<p> <ins><b>Kategoria felvitele: </b></ins></p>
    <form method='post' action='kezeles.php'>

    <label for=\"rname\">Neve:</label>
  <input type=\"text\" id=\"kategoria_neve\" name=\"kategoria_neve\" required   >
   <input type='submit' value='Hozzáadás'>

 </form>  
</br>
<div class='table-wrapper-scroll-y my-custom-scrollbar'>

<ul class=\"list-group\">
  ";
    foreach ($kategoriak as $kategoria) {
        $kat = $kategoria["id"];
        $sql = "select count(*) as db from kategoriak where kategoria_id=$kat ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $kat = $row["db"];
            }
        }
        echo "  <li class=\"list-group-item d-flex justify-content-between align-items-center\">" . $kategoria["neve"] . "     <span class=\"badge badge-primary badge-pill\">$kat</span> </li>";
    }

    echo "
</ul> </div></div> ";

    echo "</table> </div></div>";

    if (isset($_POST["kategoria_neve"])) {
        $kategoria = $_POST["kategoria_neve"];
        $kategoria = trim($kategoria);
        $kategoria = stripslashes($kategoria);
        $kategoria = htmlspecialchars($kategoria);

        $stmt = $conn->prepare('insert into kategoria (neve) values (?)');
        $stmt->bind_param('s', $kategoria);

        $stmt->execute();
        echo '<script language="javascript">';
        echo 'alert("Sikeres kategoria feltöltés")';
        echo '</script>';

    }
}

if (isset($_POST["etlap_modositas"])) {
    $status = 0;
    $status = $_POST["recept_status"];
    if ($status == 1) {
        $status = 0;

    } else {
        $status = 1;

    }

    $sq2 = "select id from uzenetek_ticket where felhasznalo_id=" . $_POST["szerzo_id"] . " and tema_id=0";
    $y = $conn->query($sq2);
    if ($y ->num_rows > 0) {
        while($sor = $y >fetch_assoc()) {
            $ticket_id=$sor['id'];
            $ido=date("Y-m-d H:i:s");
            if ($status=1){            $sq3 = "insert into uzenetek (ticket_id,user_boolean,uzenet,mikor) values ($ticket_id,0,'Recepted felkerűlt az étlapra!', '$ido')";
            }else{            $sq3 = "insert into uzenetek (ticket_id,user_boolean,uzenet,mikor) values ($ticket_id,0,'Recepted lekerűlt az étlapról!', '$ido')";
            }
            $z = $conn->query($sq3);


        }
    }

    $sql = "UPDATE recept  set hidden =$status where id=" . $_POST["recept_az"] . "  ";
    $result = $conn->query($sql);
    echo '<script language="javascript">';
    echo 'alert("Sikeresen módosítottad a recept láthatóságát.")';
    echo '</script>';

}


$conn->close();}else{
    echo "<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... lehet eltévedtünk</font></h1></div>
    ";
}
?>