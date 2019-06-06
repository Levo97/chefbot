<?php
include_once 'include/menu.php'
?>
        <?php
        $sql = "SELECT * FROM recept ORDER BY mikor DESC LIMIT 3";
        $result = $conn->query($sql);

        ?>
            <h3 style="color: white">Legfrissebb receptek:</h3>

            <h2><?php if ($result->num_rows > 0) {
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
                    echo "0 results";
                }
                ?></h2>
<hr style="display: none" id="vonal">
    <h3 style="color: white; display: none" id="favoritId">Kedvenc receptjeim:</h3>
    <div  style='height: 300px; overflow-y: auto'>
    <?php
    if(isset($_SESSION["id"])) {
        $uid = $_SESSION["id"];
        $sql = "SELECT * FROM recept, pontozas WHERE pontozas.ki=" . $uid . " AND pontozas.fel=1 AND pontozas.mit=recept.id";
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
    }?>
    </div>
</div>
    </div>
    </div>
</div>


</body>
</html>
