<?php
include_once 'include/menu.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<?php
$stmt = $conn->prepare('SELECT recept.id as recept_id, recept.neve as recept_neve , kategoria.id as kategoria_id, kategoria.neve as kategoria_neve from recept,kategoriak,kategoria where kategoria.id=kategoriak.kategoria_id and kategoriak.recept_id=recept.id  order by kategoria_id,recept_neve');
$stmt->execute();
$result3 = $stmt->get_result();
$kategoriak_lekerdezes=array();


if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
        array_push($kategoriak_lekerdezes, array($row3["recept_id"], $row3["kategoria_id"]));

    } }

$stmt = $conn->prepare('SELECT recept.id as recept_id, recept.neve as recept_neve , alapanyagok.id as alapanyag_id, alapanyagok.neve as alapanyag_neve from recept,alapanyagok,hozzavalok where alapanyagok.id=hozzavalok.alapanyag_id and hozzavalok.recept_id=recept.id order by alapanyagok.id,recept_neve');
$stmt->execute();
$result4 = $stmt->get_result();
$alapanyagok_lekerdezes=array();

if ($result4->num_rows > 0) {
    while ($row4 = $result4->fetch_assoc()) {
        array_push($alapanyagok_lekerdezes, array($row4["recept_id"], $row4["alapanyag_id"]));

    } }

$stmt = $conn->prepare('SELECT id,neve from alapanyagok order by neve');
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div align='middle'><div class=\"doboz\" style='display:inline-block; border-style: solid;  border-width: 7px; border-color: #818181;' align='middle' >
<div align='middle' > <div  style='max-width:300px;' >  <img src='include/img/search.png' > </br>
    </div></div><form method='post' action='reszletes.php'>
<table  >
  <tr>  
  
  <th>   <input  class=\"form-control\" type=\"text\" id=\"nev\" name=\"nev\" maxlength=\"20\" placeholder=\"Recept neve (opcionális)\"></th>
 
  <th>
    <select data-live-search=\"true\" data-live-search-style=\"startsWith\" class=\"selectpicker form-control\" multiple name=\"adatok[]\" >
    <optgroup label=\"Hozzávalók\">";
while ($row = $result->fetch_assoc()) {

    echo "<option id='" . $row['neve'] . "' value='" .$row['neve'] . "'>" . $row['neve'] . "</option>";

}echo "</optgroup>";

    $stmt = $conn->prepare('SELECT id,neve from kategoria  order by neve');
    $stmt->execute();
    $result2 = $stmt->get_result();
if ($result->num_rows > 0) {
    echo " <optgroup label=\"Kategóriák\">";
    while ($row2 = $result2->fetch_assoc()) {
        echo "<option id='" . $row2['neve'] . "' value='" .$row2['neve'] . "'>" . $row2['neve'] . "</option>";

    }echo "</optgroup>";
}echo "</select></th>
  <th>
  <button class=\"btn btn-unique btn-rounded btn-sm my-0\" type=\"submit\">Keresés</button>

</th>
</tr>
</table></form></div></div>";
}


if (isset($_POST["adatok"])){

    $adatok=array();
    $adatok= $_POST["adatok"];

    $stmt = $conn->prepare('SELECT alapanyagok.id as alapanyag_id, alapanyagok.neve as alapanyag_neve from alapanyagok,hozzavalok where hozzavalok.alapanyag_id=alapanyagok.id order by neve');
    $stmt->execute();
    $result = $stmt->get_result();
    $alapanyagok = array();
    $kategoriak = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($adatok as $adat) {
                if ($adat==$row["alapanyag_neve"]){
                    array_push($alapanyagok,$row["alapanyag_id"]);
                }
            }
        }
        $stmt2 = $conn->prepare('SELECT kategoria.id as kategoria_id, kategoria.neve as kategoria_neve from kategoria order by neve');
        $stmt2->execute();
        $result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        foreach ($adatok as $adat) {
            if ($adat==$row2["kategoria_neve"]){
                array_push($kategoriak,$row2["kategoria_id"]);

            }
        }

    }

    $rendezett_alapanyagok = array();
    $rendezett_kategoriak = array();
    $szamlalo=1;
    foreach ($alapanyagok as $alapanyag){

        if ($alapanyag!=NULL && $alapanyag >0){
        while ($alapanyag!=$szamlalo){
            $szamlalo++;

        } array_push($rendezett_alapanyagok,$szamlalo); $szamlalo=1; }
    }
    $szamlalo=1;
    foreach ($kategoriak as $kategoria){
        if ($kategoria > 0){
            while ($kategoria!=$szamlalo){
                $szamlalo++;

            }  array_push($rendezett_kategoriak,$szamlalo); $szamlalo=1; }

    }

    $egyezes=array();
//Logaritmikus keresés

   function binaryKereses(Array $arr, $elso, $utolso, $x){
        if ($utolso < $elso)
            return 0;

        $mid = floor(($utolso + $elso)/2);
        if ($arr[$mid][1] == $x)
            return $arr[$mid][0];

        elseif ($arr[1] > $x) {

            return binaryKereses($arr, $elso, $mid - 1, $x);
        }
        else {

            return binaryKereses($arr, $mid + 1, $utolso, $x);
        }
    }

foreach ($rendezett_kategoriak as $rendezett_kategoria){
        $arr =$kategoriak_lekerdezes;
        $value = $rendezett_kategoria;
            $eredmeny= binaryKereses($arr, 0, count($arr)-1 , $value);
            echo $eredmeny;
            if ($eredmeny>0){
               if (isset($egyezes["$eredmeny"])){ $egyezes["$eredmeny"]=$egyezes["$eredmeny"]+1 ;}else{
                   $egyezes["$eredmeny"]=1 ;
               }
            }

}

foreach ($rendezett_alapanyagok as $rendezett_alapanyag){
    $arr =$alapanyagok_lekerdezes;
    $value = $rendezett_alapanyag;
    $eredmeny= binaryKereses($arr, 0, count($arr)-1 , $value);
    if ($eredmeny>0){
        if (isset($egyezes["$eredmeny"])){ $egyezes["$eredmeny"]=$egyezes["$eredmeny"]+1 ;}else{
            $egyezes["$eredmeny"]=1 ;
        }
    }

}
asort($egyezes);
var_dump($egyezes);
    echo " <div class=\"doboz\"  >";



key();

 
 
 echo"</div>";


}


    }



}

echo "</div>";
 ?>




</body>
</html>


