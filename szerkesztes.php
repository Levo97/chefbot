<?php include_once 'include/menu.php';

echo "<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css\">
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css\"/>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js\"></script>";
if( isset($_POST['torles'])){
$recept_id_x=$_POST['torles'];

    $stmt = $conn->prepare("delete from  hozzaszolasok where recept_id= ? ");
     $stmt->bind_param('s', $recept_id_x);
    $stmt->execute();

    $stmt = $conn->prepare("delete from  hozzavalok where recept_id= ? ");
     $stmt->bind_param('s', $recept_id_x);
    $stmt->execute();

    $stmt = $conn->prepare("delete from  kategoriak where recept_id= ? ");
     $stmt->bind_param('s', $recept_id_x);
    $stmt->execute();

    $stmt = $conn->prepare("delete from  pontozas where mit= ? ");
     $stmt->bind_param('s', $recept_id_x);
    $stmt->execute();

     $stmt = $conn->prepare("delete from  recept where id= ? ");
     $stmt->bind_param('s', $recept_id_x);
    $stmt->execute();

        $recept_id_x = str_replace(' ', '', $recept_id_x);

        $target_dir = "include/img/";
        $target_file = $target_dir . $recept_id_x.".jpg";

        unlink($target_file);

                    echo "<script>window.location.href = 'index.php';</script> ";


}
if (isset($_POST["recept_az"]) && isset($_SESSION['id'])) {

    $uid = $_SESSION['id'];

    $stmt = $conn->prepare('SELECT * FROM jogok where felhasznalok_id= ?');
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $jogom = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $jogom = array_merge($jogom, array('recept' => $row["recept_moderate"]));
        }

    }

    $recept_id = $_POST["recept_az"];
    $sql = "SELECT neve,leiras, szerzo_id,missing_data FROM recept where id= $recept_id";
    $result = $conn->query($sql);
    $recept = array();


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $recept = array_merge($recept, array('id' => $recept_id, 'neve' => $row["neve"], 'szerzo_id' => $row["szerzo_id"], 'leiras' => $row["leiras"],'egyeb' => $row["missing_data"]));

        }
    }

    $sql = "SELECT * FROM kategoria";
    $result = $conn->query($sql);
    $kategoriak = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id' => $row["id"], 'neve' => $row["neve"]));
        }
    }


    $sql = "SELECT kategoria_id as id , kategoria.neve as neve FROM kategoriak,kategoria where kategoria.id=kategoriak.kategoria_id and recept_id=$recept_id";
    $result = $conn->query($sql);
    $kivalasztott_kat = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kivalasztott_kat, array('id' => $row["id"], 'neve' => $row["neve"]));
        }
        $kat_index = 0;
    }


    $sql = "SELECT alapanyagok_id,mertekegyseg_id , mertekegyseg.neve as mertekegyseg_neve, alapanyagok.neve as alapanyag_neve FROM alapanyagok_meretekegyseg,mertekegyseg, alapanyagok where mertekegyseg.id=alapanyagok_meretekegyseg.mertekegyseg_id and alapanyagok_meretekegyseg.alapanyagok_id=alapanyagok.id ";
    $result = $conn->query($sql);
    $alapanyagok = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($alapanyagok, array('alapanyagok_id' => $row["alapanyagok_id"], 'alapanyag_neve' => $row["alapanyag_neve"], 'mertekegyseg_neve' => $row["mertekegyseg_neve"], 'mertekegyseg_id' => $row["mertekegyseg_id"]));
        }

    }


    $sql = "SELECT hozzavalok.alapanyag_id as id , alapanyagok.neve as neve , mennyiseg FROM hozzavalok,alapanyagok where hozzavalok.alapanyag_id=alapanyagok.id and recept_id=$recept_id";
    $result = $conn->query($sql);
    $recept_alapanyagok = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($recept_alapanyagok, array('id' => $row["id"], 'neve' => $row["neve"], 'mennyiseg' => $row["mennyiseg"]));
        }
    }
    $script_tombnek=array();
    $script_tombnek_szamlalo=0;
    foreach ($recept_alapanyagok as $recept_alapanyag){
        $script_tombnek[$script_tombnek_szamlalo]=array($recept_alapanyag["id"],$recept_alapanyag["mennyiseg"]);
        $script_tombnek_szamlalo++;


    }

    if (($recept["szerzo_id"] != $uid) && $jogom["recept"] != 1) {
        echo "<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... valami nincs itt rendben</font></h1></div>
    ";
    } else {


        $steps = $recept["leiras"];
        $step = explode("</li>", $steps);

        $step_num = count($step);


        for ($i = 0; $i < $step_num; $i++) {
            $step[$i] = str_replace('<li>', '', $step[$i]);


        }


    }
    $string = str_replace(' ', '', $recept_id);
$kep="include/img/".$string.".jpg";
    echo "  
  <div class='doboz'> 
      <form action=\"update.php\" method=\"post\" enctype=\"multipart/form-data\">
 <input type='hidden' id='szerkesztes' name='szerkesztes' value='".$recept_id."'>
<div  class='col-sm-5' style='float:right'>
                          <div  style='max-width:300px;' >   <img class='img-rounded' src='$kep'   style='border:5px solid black; '> </div> 
                           </div> 
                        
  <h3>A recepted neve:</h3>
        <input type=\"text\" id=\"nev\" name=\"nev\" maxlength=\"20\" placeholder=\"Recept neve\" value='" . $recept["neve"] . "' required><br>
 

  <h3>Hozzávalók:</h3>

        <div id=\"hozzavalok\" class=\"form-group\">
            <div id=\"hozzavalo\">
                <select id=\"alapanyag\" name=\"1\" onchange=\"frissit(0)\" class=\"form-control\" required>
                    <option disabled selected value> Válassz...</option>";

    foreach ($alapanyagok as $alapanyag) {
        echo "<option id='" . $alapanyag['mertekegyseg_id'] . "' value='" . $alapanyag['alapanyagok_id'] . "'>" . $alapanyag['alapanyag_neve'] . "</option>";
    }

    echo "  
</select><input type=\"number\" min=\"0\" step=\"any\" name=\"2\" class=\"form-control\" id=\"mennyi\"><select
                        id=\"mertekegyseg\" name=\"3\" class=\"form-control\">
                </select>
            </div>
        </div>
        <button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"alapanyag_add()\" style=\"margin-top: 1%\"><span
                    class=\"glyphicon glyphicon-plus\"></span> Új alapanyag
        </button>
        <button type=\"button\" id=\"elveszgomb_2\" class=\"btn btn-default btn-sm\" disabled onclick=\"alapanyag_rm()\"
                style=\"margin-top: 1%\"><span class=\"glyphicon glyphicon-minus\"></span> Mégsem
        </button>


  <h3>Kategóriák:</h3>
        <select data-live-search=\"true\" data-live-search-style=\"startsWith\" class=\"selectpicker\" multiple
                name=\"kategoriak[]\" required>";
    foreach ($kategoriak as $kategoria) {
        foreach ($kivalasztott_kat as $kivalasztott) {
            if ($kategoria['id'] == $kivalasztott['id']) {
                echo "<option id='" . $kategoria['id'] . "' value='" . $kategoria['id'] . "' selected=\"selected\">" . $kategoria['neve'] . "</option>";

            }
        }
        echo "<option id='" . $kategoria['id'] . "' value='" . $kategoria['id'] . "'>" . $kategoria['neve'] . "</option>";
    }


    echo "        </select>
        
        
        
        
 <h3>A recept leírása:</h3>
        <div id=\"leiras\">
        </div>
        <button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"hozzaad()\" style=\"margin-top: 1%\">
            <span class=\"glyphicon glyphicon-plus\"></span> Következő lépés
        </button>
        <button type=\"button\" id=\"elveszgomb\" class=\"btn btn-default btn-sm\" disabled onclick=\"elvesz()\"
                style=\"margin-top: 1%\">
            <span class=\"glyphicon glyphicon-minus\"></span> Visszavonás
        </button>
        
        <script type=\"text/javascript\">
var lepesek = ";
    echo json_encode($step);
    echo ";

var hozzavalokasd = ";
    echo json_encode($script_tombnek);
    ?>
</script>



 <h3>Kép módosítása:</h3>
        <input type="file"  id="fileToUpload" name="fileToUpload">
        <input type="hidden" id="szoveg" name="szoveg">
        <input type="hidden" id="azonosito" name="azonosito">


                     <script>
            var h4 = document.createElement("h4");
            var lepes = document.createTextNode("1. lépés");
            h4.appendChild(lepes);
            document.getElementById("leiras").appendChild(h4);
            var textarea = document.createElement("textarea");
            document.getElementById("leiras").appendChild(textarea);
            document.getElementsByTagName("textarea")[0].setAttribute("class", "form-control");
            document.getElementsByTagName("textarea")[0].setAttribute("id", "text1");
            document.getElementsByTagName("textarea")[0].setAttribute("name", "text1");
            document.getElementsByTagName("textarea")[0].setAttribute("required", "");

            document.getElementsByTagName("textarea")[0] .value=lepesek[0];
            var darab = 1;

            for (var i=0; i<lepesek.length-2;i++){
                hozzaad();
            }

            function hozzaad() {
                darab++;
                var h4 = document.createElement("h4");
                var lepes = document.createTextNode(darab + ". lépés");
                h4.appendChild(lepes);
                document.getElementById("leiras").appendChild(h4);
                var textarea = document.createElement("textarea");
                document.getElementById("leiras").appendChild(textarea);
                document.getElementsByTagName("textarea")[darab - 1].setAttribute("class", "form-control");
                document.getElementsByTagName("textarea")[darab - 1].setAttribute("id", "text" + darab);
                document.getElementsByTagName("textarea")[darab - 1].setAttribute("name", "text" + darab);
                   if (darab<=lepesek.length) {
                                   document.getElementsByTagName("textarea")[darab - 1] .value=lepesek[darab - 1];

                   }

                document.getElementById("elveszgomb").disabled = false;
            }

            function elvesz() {
                if (darab > 1) {
                    var leiras = document.getElementById("leiras");

                    leiras.removeChild(document.getElementsByTagName("textarea")[darab - 1]);
                    leiras.removeChild(document.getElementsByTagName("h4")[darab - 1]);
                    darab--;

                    if (darab == 1) {
                        document.getElementById("elveszgomb").disabled = true;

                    }

                }
            }
        </script>


<h4>egyéb nem rögzíthető adatok: </h4>
        <textarea id="egyeb" name="egyeb" class="form-control" id="exampleFormControlTextarea1" rows="1"  placeholder='<?php echo $recept["egyeb"];?>' ></textarea>


        <button style="margin-top: 1%;" type="submit" class="btn btn-success" onclick="fuz()">Feltöltöm</button>



  </form> <form method='post' action='szerkesztes.php'>
<button style="margin-top: 1%;" type="submit" name="torles" class="btn btn-danger" value="<?php echo $recept_id; ?>">Recept törlése</button>
</form>



     <script>

            function fuz() {
                var szoveg = document.getElementById("szoveg");
                var ossze = "";
                for (var k = 1; k <= darab; k++) {
                    var leiras = document.getElementById(`text${k}`).value;
                    ossze += `<li>${leiras}</li>`;
                }
                szoveg.value = ossze;
            }
        </script>
    </form>



    <script>

        var azonosito = 3;
        document.getElementById("azonosito").value = azonosito;


        // a hozzávalók mértékegységét frissíti a kiválasztott alapanyag függvényében
       function frissit(index) {


            var hozzavalok_sum = document.getElementById("hozzavalok");

            var current = hozzavalok_sum.getElementsByTagName("div")[index];
            var x = current.children[0];
            current.children[2].innerHTML = "";
            var lista = current.children[2];

            if (x.options[x.selectedIndex].id == 1) {
                var option = document.createElement("option");
                option.setAttribute("value", "db");
                option.innerText = "db";

                lista.appendChild(option);

            } else if (x.options[x.selectedIndex].id == 3) {
                var option = document.createElement("option");
                option.setAttribute("value", "g");
                option.innerText = "g";
                lista.appendChild(option);

                var option = document.createElement("option");
                option.setAttribute("value", "dkg");
                option.innerText = "dkg";
                lista.appendChild(option);

                var option = document.createElement("option");
                option.setAttribute("value", "kg");
                option.innerText = "kg";
                lista.appendChild(option);
            } else if (x.options[x.selectedIndex].id == 2) {
                var option = document.createElement("option");
                option.setAttribute("value", "ml");
                option.innerText = "ml";
                lista.appendChild(option);

                var option = document.createElement("option");
                option.setAttribute("value", "cl");
                option.innerText = "cl";
                lista.appendChild(option);

                var option = document.createElement("option");
                option.setAttribute("value", "dl");
                option.innerText = "dl";
                lista.appendChild(option);

                var option = document.createElement("option");
                option.setAttribute("value", "l");
                option.innerText = "l";
                lista.appendChild(option);
            }
        }

        console.log(hozzavalokasd);
        var szamlalo = 1;
                document.getElementById("alapanyag").value  =  hozzavalokasd[0][0];
              //document.getElementById("alapanyag").selectedIndex =  hozzavalokasd[0][0];
              document.getElementsByName('2')[0].value= hozzavalokasd[0][1];
         frissit(0);

              var szekeztes_szamlalo=3;

         for (var i=1;i<hozzavalokasd.length;i++){
             alapanyag_add();
             szekeztes_szamlalo++;
             document.getElementsByName(szekeztes_szamlalo)[0].value=hozzavalokasd[i][0];
                          szekeztes_szamlalo++;
              document.getElementsByName(szekeztes_szamlalo)[0].value= hozzavalokasd[i][1];
               szekeztes_szamlalo++;
         frissit(i);

         }

        function alapanyag_add() {
            azonosito++;
            var x = document.getElementById("alapanyag");
            var y = x.cloneNode(true);
            y.setAttribute("name", azonosito);
            azonosito++;
            var hozzavalo = document.createElement("div");
            hozzavalo.setAttribute("id", "hozzavalo");
            y.setAttribute("onchange", "frissit(" + szamlalo + ")");

            hozzavalo.appendChild(y);
            var szam = document.createElement("input");
            szam.setAttribute("type", "number");
            szam.setAttribute("min", "0");
            szam.setAttribute("step", "any");
            szam.id = "mennyi";
            szam.className = "form-control";

            szam.setAttribute("name", azonosito);

            azonosito++;
            hozzavalo.appendChild(szam);

            var mertek = document.createElement("select");
            mertek.className = "form-control";
            mertek.id = "mertekegyseg";


            mertek.setAttribute("name", azonosito);

            hozzavalo.appendChild(mertek);

            document.getElementById("hozzavalok").appendChild(hozzavalo);

            szamlalo++;
            document.getElementById("elveszgomb_2").disabled = false;

            document.getElementById("azonosito").value = azonosito;

        }

        function alapanyag_rm() {

            var hozzavalok = document.getElementById("hozzavalok");
            var hozzavalo = hozzavalok.getElementsByTagName("div")[szamlalo - 1];
            document.getElementById("hozzavalok").removeChild(hozzavalo);
            szamlalo--;
            if (szamlalo < 2) {
                document.getElementById("elveszgomb_2").disabled = true;

            }
            azonosito = azonosito - 3;


        }

    </script>
       <?php


} else {
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... valami nincs itt rendben</font></h1></div></div>
    ";
}