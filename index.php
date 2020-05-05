<?php
include_once 'include/menu.php'
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<?php
$sql = "SELECT * FROM recept where recept.hidden!=1 ORDER BY mikor DESC LIMIT 3";
$result = $conn->query($sql);


if (isset($_SESSION["id"])) {
    echo "<div align='middle' > <div  style='max-width:300px;' >  <img src='include/img/chefbot.png' > </br>
    <h1><font color='white'>Üdv újra " . $_SESSION['user'] . "!</font></h1></div></div>";
} else { ?>

    <div align='middle'>
        <div style='max-width:300px;'><img src='include/img/chefbot.png'> </br>
            <h1><font color='white'>Üdv a konyhában! Mit főzzünk ma?</font></h1></div>
    </div>

    <?php
}
?>
<div class="container" style="color: white; "><h2
            style="transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0;">Frissen a sütőből</h2>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">


        <!-- Wrapper for slides -->
        <div class="carousel-inner">


            <?php $elso = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($elso == 1) {
                        echo " <div class=\"item active\">";
                    } else {
                        echo " <div class=\"item\">";
                    }
                    $elso++;
                    echo "   <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%; border-radius: 20px 20px 20px 20px \" > </div>
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

        <a class="left carousel-control" style='border-radius: 20px 20px 20px 20px;' href="#myCarousel"
           data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" style='border-radius: 20px 20px 20px 20px;' href="#myCarousel"
           data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<hr style="display: none" id="vonal">

<?php

$elso = 1;

$sql = "SELECT mit as id,recept.neve as neve ,mikor,sum(pont)as pontok FROM pontozas,recept where recept.id =pontozas.mit and recept.hidden!=1 GROUP by id ORDER by pontok desc limit 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "
<div class=\"container\" style=\"color: white\">
   <h2 style=\"transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0; \">Legjobbjaink </h2>
    <div id=\"myCarousel5\" class=\"carousel slide\" data-ride=\"carousel\">


        <div class=\"carousel-inner\">";
    while ($row = $result->fetch_assoc()) {
        if ($elso == 1) {
            echo " <div class=\"item active\">";
        } else {
            echo " <div class=\"item\">";
        }
        $elso++;
        echo "

  <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%; border-radius: 20px 20px 20px 20px \" > </div>
                </div>
                <div class='col-sm-7' >
                    <h2>" . $row["neve"] . "</h2>
                    <p>" . $row["mikor"] . "</p>
                </div></a>
            </div>";
    }
    echo "
    </div>

    <a class=\"left carousel-control\" style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel5\" data-slide=\"prev\">
        <span class=\"glyphicon glyphicon-chevron-left\"></span>
        <span class=\"sr-only\">Previous</span>
    </a>
    <a class=\"right carousel-control\"  style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel5\" data-slide=\"next\">
        <span class=\"glyphicon glyphicon-chevron-right\"></span>
        <span class=\"sr-only\">Next</span>
    </a>
</div>
</div>";

}


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($elso == 1) {
            echo " <div class=\"item active\">";
        } else {
            echo " <div class=\"item\">";
        }
        $elso++;
        echo "   <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%; border-radius: 20px 20px 20px 20px \" > </div>
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



<?php
if (isset($_SESSION["id"])) {
    $uid = $_SESSION["id"];

    $sql = "SELECT hozzavalok.recept_id,hozzavalok.alapanyag_id FROM hozzavalok,recept,pontozas where hozzavalok.recept_id =recept.id and recept.id=pontozas.mit and pontozas.ki=" . $uid . " and pontozas.pont=1 GROUP by alapanyag_id ORDER by alapanyag_id";
    $result = $conn->query($sql);
    $kedvelt_hozzavalok = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kedvelt_hozzavalok, array('recept_id' => $row["recept_id"], 'alapanyag_id' => $row["alapanyag_id"]));
        }
    }

    $uid = $_SESSION["id"];
    $sql = "SELECT kategoriak.recept_id,kategoriak.kategoria_id FROM kategoriak,recept,pontozas where kategoriak.recept_id =recept.id and recept.id=pontozas.mit and pontozas.ki=" . $uid . "  and pontozas.pont=1 GROUP by kategoria_id order by kategoria_id";
    $result = $conn->query($sql);
    $kedvelt_kategoriak = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($kedvelt_kategoriak, array('recept_id' => $row["recept_id"], 'kategoria_id' => $row["kategoria_id"]));
        }
    }

    $stmt = $conn->prepare('SELECT recept.id as recept_id, recept.neve as recept_neve , kategoria.id as kategoria_id, kategoria.neve as kategoria_neve from recept,kategoriak,kategoria where kategoria.id=kategoriak.kategoria_id and kategoriak.recept_id=recept.id  order by kategoria_id,recept_neve');
    $stmt->execute();
    $result3 = $stmt->get_result();
    $kategoriak_lekerdezes = array();


    if ($result3->num_rows > 0) {
        while ($row3 = $result3->fetch_assoc()) {
            array_push($kategoriak_lekerdezes, array($row3["recept_id"], $row3["kategoria_id"]));

        }
    }

    $stmt = $conn->prepare('SELECT recept.id as recept_id, recept.neve as recept_neve , alapanyagok.id as alapanyag_id, alapanyagok.neve as alapanyag_neve from recept,alapanyagok,hozzavalok where alapanyagok.id=hozzavalok.alapanyag_id and hozzavalok.recept_id=recept.id order by alapanyagok.id,recept_neve');
    $stmt->execute();
    $result4 = $stmt->get_result();
    $alapanyagok_lekerdezes = array();

    if ($result4->num_rows > 0) {
        while ($row4 = $result4->fetch_assoc()) {
            array_push($alapanyagok_lekerdezes, array($row4["recept_id"], $row4["alapanyag_id"]));

        }
    }


    $stmt = $conn->prepare('SELECT recept.id FROM recept,pontozas where recept.id=pontozas.mit and pontozas.ki=2 and pontozas.pont=1 order by recept.id ');
    $stmt->execute();
    $result4 = $stmt->get_result();
    $kedvlet = array();

    if ($result4->num_rows > 0) {
        while ($row4 = $result4->fetch_assoc()) {
            array_push($kedvlet, $row4["id"]);

        }
    }

    $egyezes = array();

    function binaryKereses(Array $arr, $elso, $utolso, $x)
    {
        if ($utolso < $elso)
            return -1;

        $mid = floor(($utolso + $elso) / 2);
        if ($arr[$mid][1] == $x) {
            return $mid;

        } elseif ($arr[$mid][1] > $x) {

            return binaryKereses($arr, $elso, $mid - 1, $x);
        } else {

            return binaryKereses($arr, $mid + 1, $utolso, $x);
        }
    }

    $arr = $kategoriak_lekerdezes;

    foreach ($kedvelt_kategoriak as $rendezett_kategoria) {
        $value = $rendezett_kategoria["kategoria_id"];
        $eredmeny = 0;
        $talalat = 0;
        while ($talalat != -1) {
            $talalat = binaryKereses($arr, 0, count($arr) - 1, $value);
            if ($talalat != -1) {

                $eredmeny = $arr[$talalat][0];

                $arr[$talalat][1] = 0;


                if (isset($egyezes["$eredmeny"])) {
                    $egyezes["$eredmeny"] = $egyezes["$eredmeny"] + 1;
                } else {
                    $egyezes["$eredmeny"] = 1;
                }
            }
        }
    }
    $arr = $alapanyagok_lekerdezes;

    foreach ($kedvelt_hozzavalok as $rendezett_alapanyag) {
        $value = $rendezett_alapanyag["alapanyag_id"];
        $eredmeny = 0;
        $talalat = 0;
        while ($talalat != -1) {
            $talalat = binaryKereses($arr, 0, count($arr) - 1, $value);

            if ($talalat != -1) {

                $eredmeny = $arr[$talalat][0];
                $arr[$talalat][1] = 0;


                if (isset($egyezes["$eredmeny"])) {
                    $egyezes["$eredmeny"] = $egyezes["$eredmeny"] + 1;
                } else {
                    $egyezes["$eredmeny"] = 1;
                }
            }
        }
    }

    foreach ($kedvlet as $x) {
        if (isset($egyezes[$x])) {
            unset($egyezes[$x]);
        }
    }
    arsort($egyezes);

    $elso = 1;
    if (count($egyezes) > 0) {
        echo "<div class=\"container\" style=\"color: white\">
   <h2 style=\"transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0; \">Ajánlatunk</h2>
    <div id=\"myCarousel3\" class=\"carousel slide\" data-ride=\"carousel\">


        <div class=\"carousel-inner\">
    ";
        foreach ($egyezes as $key => $value) {
            $sql = "SELECT * FROM recept WHERE recept.hidden!=1 and  recept.id=" . $key . " ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($elso == 1) {
                        echo " <div class=\"item active\">";
                    } else {
                        echo " <div class=\"item\">";
                    }
                    $elso++;
                    echo "

  <a href='recept.php?id=" . $key . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $key . ".jpg'  style=\"width:100%;  border-radius: 20px 20px 20px 20px\" > </div>
                </div>
                <div class='col-sm-7' >
                    <h2>" . $row["neve"] . "</h2>
                    <p>" . $row["mikor"] . "</p>
                </div></a>
            </div>";
                }
            }
        }
        echo "
    </div>

    <a class=\"left carousel-control\" style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel3\" data-slide=\"prev\">
        <span class=\"glyphicon glyphicon-chevron-left\"></span>
        <span class=\"sr-only\">Previous</span>
    </a>
    <a class=\"right carousel-control\"  style='border-radius: 20px 20px 20px 20px;' href=\"#myCarousel3\" data-slide=\"next\">
        <span class=\"glyphicon glyphicon-chevron-right\"></span>
        <span class=\"sr-only\">Next</span>
    </a>
</div>
</div>";

    }





    $elso = 1;
    $uid = $_SESSION["id"];
    $sql = "SELECT * FROM recept, pontozas WHERE  hidden=0  and pontozas.ki=" . $uid . " AND pontozas.pont=1 AND pontozas.mit=recept.id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "
<div class=\"container\" style=\"color: white\">
   <h2 style=\"transform: rotate(90deg); color: #85b9c4; transform-origin: left top 0; \">Kedvenc receptek</h2>
    <div id=\"myCarousel2\" class=\"carousel slide\" data-ride=\"carousel\">


        <div class=\"carousel-inner\">";
        while ($row = $result->fetch_assoc()) {
            if ($elso == 1) {
                echo " <div class=\"item active\">";
            } else {
                echo " <div class=\"item\">";
            }
            $elso++;

            echo "

  <a href='recept.php?id=" . $row["id"] . "'> <div  class='col-sm-5' >
                    <div  style='max-height:200px; max-width:300px;' >   <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'  style=\"width:100%;  border-radius: 10px 10px 10px 10px\" > </div>
                </div>
                <div class='col-sm-7' >
                    <h2>" . $row["neve"] . "</h2>
                    <p>" . $row["mikor"] . "</p>
                </div></a>
            </div>";
        }
        echo "
    </div>

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

}
$conn->close(); ?>
<div>


</div>


</div>
</div>
</div>
</div>
</div>


</body>
</html>
