<?php
include_once 'include/menu.php'
?>
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

<div>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <h2><?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo " <td><div class='box'><div class='doboz '>
                        <div class='row'>
                        <a href='recept.php?id=" . $row["id"] . "'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'>
                            </div>
                            <div class='col-sm-10'>
                                <h1>" . $row["neve"] . "</h1>
                                <h5>" . $row["mikor"] . "</h5>
                            </div>
                            </a>
                        </div>   </div>    </div></td>
                        ";
                    }
                } else {
                    echo "0 results";
                }
                ?></tr>
    </table>
</div></h2>/
<hr style="display: none" id="vonal">
<div class='mssgBox '><h3 style="color: white; display: none" id="favoritId">Kedvenc receptjeim:</h3></div>
<div class='table-wrapper-scroll-y my-custom-scrollbar'>
    <div class='box'>
        <?php
        if (isset($_SESSION["id"])) {
            $uid = $_SESSION["id"];
            $sql = "SELECT * FROM recept, pontozas WHERE  hidden=0  and pontozas.ki=" . $uid . " AND pontozas.pont=1 AND pontozas.mit=recept.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='doboz'>
                        <div class='row'>
                        <a href='recept.php?id=" . $row["id"] . "'>
                            <div class='col-sm-2'>
                                <img class='img-fluid' src='include/img/" . $row["id"] . ".jpg'>
                            </div>
                            <div class='col-sm-10'>
                                <h1>" . $row["neve"] . "</h1>
                                <h5>" . $row["mikor"] . "</h5>
                            </div>
                            </a>
                        </div>
                        </div>
                        </div>
                        <script>
                                var fav = document.getElementById('favoritId');
                                fav.style.display = '';
                                var von = document.getElementById('vonal');
                                von.style.display = '';
                            </script>";
                }
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
