<?php
include_once 'include/menu.php'
?>
<?php

$id=$_GET['id'];

$sql = "SELECT * FROM recept where $id=id";
$result = $conn->query($sql);

?>
<?php if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='doboz'>
                    <div class='row'>
                        <div class='col-sm-7'>
                            <h1>".$row["neve"]."</h1>";
                            if(isset($_SESSION["user"])){
                            echo"<div style='display: table; padding-bottom: 2%'>
                            <div style='display: table-cell;'>";
                            echo "<form method='post' action='";
                                echo  "like.php'>
                                <input type='hidden' name='id' id='id' value='".$row["id"]."'>
                                <input type='hidden' name='fel' id='fel' value='1'>
                                <button type='submit' class='btn btn-default btn-sm'>
                                <span class='glyphicon glyphicon-thumbs-up'></span>Finom</button>
                            </form>
                            </div>
                            <div style='display: table-cell;'>
                            <form method='post' action='";
                            echo  "like.php'>
                                <input type='hidden' name='id' id='id' value='".$row["id"]."'>
                                <input type='hidden' name='fel' id='fel' value='0'>
                                <button type='submit' class='btn btn-default btn-sm'>
                                <span class='glyphicon glyphicon-thumbs-down'></span>Nem finom</button>
                            </form>";
                            echo"</div></div>";
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
                        </div>";
                        echo "<div class='col-sm-5'>
                            <img class='img-fluid' src='include/img/".$row["id"].".jpg'>
                        </div>
                    <h4 style='float:right'>".$row["mikor"]."</h4>
                    </div>
            </div>";
        }
    } else {
        echo "0 results";
    }


    ?>
<div class="doboz" style="padding-top: 2%;">
    <div style=" height:300px; overflow-y: auto;">
    <?php
    if(isset($_POST['text'])) {
        $sessId = $_SESSION["id"];
        $sql3 = "INSERT INTO hozzaszolasok values ($id,$sessId,'".$_POST['text']."')";
        if ($conn->query($sql3) === TRUE) {
            //echo "<script>window.location.href = ".$_SERVER["PHP_SELF"].";</script> ";

        } else {
            echo "Error: " . $sql3 . "<br>" . $conn->error;
        }
    }

    $sql2 = "SELECT mit, username FROM hozzaszolasok, felhasznalok where $id=hozzaszolasok.recept_id AND hozzaszolasok.ki=felhasznalok.id";

    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

    echo "
<div class='mssgBox'>
<h3> ".$row["username"]."</h3>
    <p>".$row["mit"]."</p>
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
</form >";
}
    $conn->close();
?>
</div>
</div>
</div>



</body>
</html>
