<?php
include_once 'include/menu.php';
if (isset($_SESSION["id"])){

$uid = $_SESSION['id'];

$sql = "SELECT id,neve,mikor FROM recept where szerzo_id='$uid' order by mikor desc";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='mssgBox ' style='background-color:   #eaeded  ;'>
                        <div class='row'>
                        <a href='recept.php?id=" . $row["id"] . "'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'>
                            </div>
                            <div class='col-sm-10'>
                                <h1>" . $row["neve"] . "</h1>
                                <h5>" . $row["mikor"] . "</h5>
                                 <form method='post' action='szerkesztes.php'>
   
   <button id=\"recept_az\" name=\"recept_az\" type=\"submit\" class=\"btn btn-primary\" value='" . $row["id"] . " '>Szerkesztés</button></form>
                            </div>
                            </a>
                        </div>
                        </div>";
    }
} else {
    echo "<div  align='middle'  ><div  style='max-width:500px;'>  <img src='include/img/search.png' > </br>
             <h1><font color='white' style='color: #05728f' >  még nincs recepted  </font></h1></div></div>
    ";
}

$conn->close();
} else {
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... valami nincs itt rendben</font></h1></div></div>
    ";

}
?>