<?php
include_once 'include/menu.php'
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




<?php
$sql = "SELECT * FROM recept where hidden=0 ORDER BY mikor DESC LIMIT 3";
$result = $conn->query($sql);


if (isset($_SESSION["id"])) {
    echo "<div align='middle' > <div  style='max-width:300px;' >  <img src='include/img/chefbot.png' > </br>
    <h1><font color='white'>Üdv újra " . $_SESSION['user'] . " !</font></h1></div></div>";
} else { ?>

    <div align='middle'>
        <div style='max-width:300px;'><img src='include/img/chefbot.png'> </br>
            <h1><font color='white'>Üdv a konyhában! Mit főzzünk ma?</font></h1></div>
    </div>

    <?php
}
?>
<div class="container" style="color: white; ">  <h2 style="transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0;">Frissen a sütőből</h2>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">


        <!-- Wrapper for slides -->
        <div class="carousel-inner">



                <?php $elso=1; if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                     if ($elso==1){  echo " <div class=\"item active\">";}else{ echo " <div class=\"item\">";}
                  $elso++;   echo"   <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%; border-radius: 10px 10px 10px 10px \" > </div>
                </div>
                <div  class='col-sm-7'>
                    <h2>" . $row["neve"] . "</h2>
                    <p>" . $row["mikor"] . "</p>
                </div></a>
            </div>
             
           
                        ";
                    }
                } else {
                    echo "0 results";
                }
                ?>


    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" style='border-radius: 20px 20px 20px 20px;' href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" style='border-radius: 20px 20px 20px 20px;' href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>

<hr style="display: none" id="vonal">


        <?php
        if (isset($_SESSION["id"])) {

            $elso=1;
            $uid = $_SESSION["id"];
            $sql = "SELECT * FROM recept, pontozas WHERE  hidden=0  and pontozas.ki=" . $uid . " AND pontozas.pont=1 AND pontozas.mit=recept.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo"
<div class=\"container\" style=\"color: white\">
   <h2 style=\"transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0; \">Kedvenc receptek</h2>
    <div id=\"myCarousel2\" class=\"carousel slide\" data-ride=\"carousel\">


        <!-- Wrapper for slides -->
        <div class=\"carousel-inner\">";
                while ($row = $result->fetch_assoc()) {
                    if ($elso==1){  echo " <div class=\"item active\">";}else{ echo " <div class=\"item\">";} $elso++;

                    echo "

  <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%;  border-radius: 10px 10px 10px 10px\" > </div>
                </div>
                <div class='col-sm-7' >
                    <h2>" . $row["neve"] . "</h2>
                    <p>" . $row["mikor"] . "</p>
                </div></a>
            </div>";}echo"
    </div>

    <!-- Left and right controls -->
    <a class=\"left carousel-control\" style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel2\" data-slide=\"prev\">
        <span class=\"glyphicon glyphicon-chevron-left\"></span>
        <span class=\"sr-only\">Previous</span>
    </a>
    <a class=\"right carousel-control\"  style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel2\" data-slide=\"next\">
        <span class=\"glyphicon glyphicon-chevron-right\"></span>
        <span class=\"sr-only\">Next</span>
    </a>
</div>
</div>

                        <script>
                                var fav = document.getElementById('favoritId');
                                fav.style.display = '';
                                var von = document.getElementById('vonal');
                                von.style.display = '';
                            </script>";

            } else {
                echo "<script>
                                var fav = document.getElementById('favoritId');
                                fav.style.display = 'none';
                                var von = document.getElementById('vonal');
                                von.style.display = 'none';
                            </script> ";
            }

            $conn->close();
        } ?>
    </div>
</div>
</div>
</div>
</div>


</body>
</html>
