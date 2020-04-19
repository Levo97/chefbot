<?php
include_once 'include/menu.php';

$uid=$_SESSION['id'];

$sql = "SELECT id,neve,mikor FROM recept where szerzo_id='$uid' order by mikor desc";

$result = $conn->query($sql);
echo "<h3 style=\"color: white\">Ezeket találtuk:</h3>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='doboz '>
                        <div class='row'>
                        <a href='recept.php?id=".$row["id"]."'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/".$row["id"].".jpg'>
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