<?php
include_once 'include/menu.php';

if (isset($_SESSION["id"]) && $_SESSION["tiltott"]!=1){
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>





<div class="doboz">
    <h1 align="center">Új recept létrehozása</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <h3>Add meg a recepted nevét:</h3>
        <input type="text" id="nev" name="nev" maxlength="50" placeholder="Recept neve" required><br>
        <img src='include/img/ujrecept.png' style=" max-width:500px; " align="right">

        <?php
        $sql = "SELECT alapanyagok_id,mertekegyseg_id , mertekegyseg.neve as mertekegyseg_neve, alapanyagok.neve as alapanyag_neve FROM alapanyagok_meretekegyseg,mertekegyseg, alapanyagok where mertekegyseg.id=alapanyagok_meretekegyseg.mertekegyseg_id and alapanyagok_meretekegyseg.alapanyagok_id=alapanyagok.id order by alapanyag_neve   ";
        $result = $conn->query($sql);
        $alapanyagok = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                array_push($alapanyagok, array('alapanyagok_id' => $row["alapanyagok_id"], 'alapanyag_neve' => $row["alapanyag_neve"], 'mertekegyseg_neve' => $row["mertekegyseg_neve"], 'mertekegyseg_id' => $row["mertekegyseg_id"]));
            }

        }

        $sql = "SELECT * FROM kategoria  ";
        $result = $conn->query($sql);
        $kategoriak = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                array_push($kategoriak, array('kategoria_id' => $row["id"], 'kategoria_neve' => $row["neve"]));
            }

        }


        ?>


        <h3>Hozzávalók:</h3>

        <div id="hozzavalok" class="form-group">
            <div id="hozzavalo">
                <select id="alapanyag" name="1" onchange="frissit(0)" class="form-control" required>
                    <option disabled selected value> Válassz...</option>
                    <?php

                    foreach ($alapanyagok as $alapanyag) {
                        echo "<option id='" . $alapanyag['mertekegyseg_id'] . "' value='" . $alapanyag['alapanyagok_id'] . "'>" . $alapanyag['alapanyag_neve'] . "</option>";
                    }

                    ?></select><input type="number" min="0" step="any" name="2" class="form-control" id="mennyi"><select
                        id="mertekegyseg" name="3" class="form-control">
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-default btn-sm" onclick="alapanyag_add()" style="margin-top: 1%"><span
                    class="glyphicon glyphicon-plus"></span> Új alapanyag
        </button>
        <button type="button" id="elveszgomb_2" class="btn btn-default btn-sm" disabled onclick="alapanyag_rm()"
                style="margin-top: 1%"><span class="glyphicon glyphicon-minus"></span> Mégsem
        </button>


        <h3>Kategóriák:</h3>
        <select data-live-search="true" data-live-search-style="startsWith" class="selectpicker" multiple name="kategoriak[]" required>
            <?php

            foreach ($kategoriak as $kategoria) {
                echo "<option id='" . $kategoria['kategoria_id'] . "' value='" . $kategoria['kategoria_id'] . "'>" . $kategoria['kategoria_neve'] . "</option>";
            }

            $conn->close();
            ?>
        </select>


        <h3>Add meg a leírást:</h3>
        <div id="leiras">
        </div>
        <button type="button" class="btn btn-default btn-sm" onclick="hozzaad()" style="margin-top: 1%">
            <span class="glyphicon glyphicon-plus"></span> Következő lépés
        </button>
        <button type="button" id="elveszgomb" class="btn btn-default btn-sm" disabled onclick="elvesz()"
                style="margin-top: 1%">
            <span class="glyphicon glyphicon-minus"></span> Visszavonás
        </button>
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

            var darab = 1;

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

        <h5>Egyéb adat:</h5>
        <textarea id="egyeb" name="egyeb" class="form-control" id="exampleFormControlTextarea1" rows="1"  placeholder="Ha a fenti mezőkben nem található a szükséges alapanyag/kategória, akkor itt rögzítheted és munkatársaink beszerzik őket. Fontos a recepthez használt mennyiség feltüntetése. PL: kategória: vegán alapanyag: 1.2 kg dió" ></textarea>

        <h3>Adj hozzá egy képet:</h3>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" id="szoveg" name="szoveg">
        <input type="hidden" id="azonosito" name="azonosito">
        <button style="margin-top: 1%;" type="submit" class="btn btn-success" onclick="fuz()">Feltöltöm</button>

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
            console.log(current.children[2]);
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

        var szamlalo = 1;

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

</div>

</div>
</div>
</body>
</html>
    <?php }else{
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... valami itt nincs rendben</font></h1></div></div>
    ";
}