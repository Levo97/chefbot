<div id="doboz">
    <?php
    include_once 'include/menu.php';

    $sql = "SELECT kategoria.id as id ,kategoria.neve as neve,count(*)  as db FROM kategoriak , kategoria where kategoriak.kategoria_id=kategoria.id group by kategoria_id ";
    $result = $conn->query($sql);

    $tags = array();


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($tags, array('weight' => $row["db"] * 50, 'tagname' => $row["neve"], 'id' => $row["id"]));
        }

    } else {
        echo "0 results";
    }

    $ret = " ";
    echo "<div class='kozep' style='top: 2000px'>";
    foreach ($tags as $tag) {


$szin="#".random_color();
        $ret .= '<a style="color:'.$szin.'; font-size: ' . $tag['weight'] . 'px;" href="/chefbot/kereses.php?id=' . $tag['id'] . '" >' . $tag['tagname'] . '</a>' . "\n";


    }
    function random_color_part() {
        return str_pad( dechex( mt_rand( 150, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }

    echo $ret;

    ?>
</div>
</body>
</html>
<?php

