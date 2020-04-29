<?php
include_once 'include/menu.php'
?>
<?php
$keres="";
if(isset($_POST["keres"])){
    $keres = $_POST["keres"];
    $keres = trim($keres);
    $keres = stripslashes($keres);
    $keres = htmlspecialchars($keres);
}    $sql = "SELECT id,neve,mikor FROM recept Where LOWER(neve) like LOWER('%$keres%') ORDER BY mikor";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "SELECT id as id,neve,mikor FROM recept,kategoriak where kategoriak.recept_id=recept.id  and kategoriak.kategoria_id='$id'";

}
$result = $conn->query($sql);

echo "<h3 style=\"color: white\">Ezeket találtuk:</h3>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='doboz '>
                        <div class='row'>
                        <a href='recept.php?id=".$row["id"]."'>
                            <div class='col-sm-2'>
                               <img class='img-fluid' src='include/img/".$row["id"].".jpg' style='max-height:200px; max-width:300px;'>
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
    echo "Nincs találat";
}

$conn->close();

?>

</div>
</div>
</div>



</body>
</html>
