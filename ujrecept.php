<?php
include_once 'include/menu.php'
?>
<div class="doboz">
<h1 align="center">Új recept létrehozása</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <h3>Add meg a recepted nevét:</h3>
        <input class="form-control" type="text" id="nev" name="nev" maxlength="20" placeholder="Recept neve"><br>
        <h3>Válszd ki a hozzávalókat:</h3>
        <div class="checkbox" style="height: 100px; overflow-y: auto">
        <?php
        $sql = "SELECT id, neve FROM alapanyagok";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <label><input type='checkbox' name='alapanyag' value=".$row['id'].">".$row['neve']."</label>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
        </div>
        <h3>Add meg a leírást:</h3>
        <div id="leiras">
        </div>
        <button type="button" class="btn btn-default btn-sm" onclick="hozzaad()" style="margin-top: 1%">
            <span class="glyphicon glyphicon-plus"></span>Következő lépés
        </button>
        <script>
            var ide = document.getElementById("leiras");
            ide.innerHTML="<h4>1. lépés:</h4><textarea class=\"form-control\" type=\"text\" id=\"text1\" name=\"text1\">";
            var darab = 1;
            function hozzaad() {
                darab++;
                var ide2 = document.getElementById("leiras");
                ide2.innerHTML+= `<h4>${darab}. lépés:</h4><textarea class="form-control" type=\"text\" id=\"text${darab}\" name=\"text${darab}\">`;

            }
        </script>
        <h3>Adj hozzá egy képet:</h3>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" id="szoveg" name="szoveg">
            <button  style="margin-top: 1%;" type="submit" class="btn btn-success" onclick="fuz()"><h3>Feltöltöm</h3></button>
        <script>
            function fuz(){
                var szoveg = document.getElementById("szoveg");
                var ossze="";
                for (var k=1; k<=darab; k++) {
                    var leiras = document.getElementById(`text${k}`).value;
                    ossze+=`<li>${leiras}</li>`;
                }
                szoveg.value=ossze;
            }
        </script>
    </form>
<?php

?>
</div>

</div>
</div>
</body>
</html>
