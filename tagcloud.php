


<div id="doboz">
    <?php
    include_once 'include/menu.php';

    $sql = "SELECT kategoria.id as id ,kategoria.neve as neve,count(*)  as db FROM kategoriak , kategoria where kategoriak.kategoria_id=kategoria.id group by kategoria_id ";
    $result = $conn->query($sql);

    $tags=array();


    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($tags, array('weight'  =>$row["db"]*10, 'tagname' =>$row["neve"], 'id' =>$row["id"]));
        }

    } else {
        echo "0 results";
    }

    $ret=" ";
    foreach($tags as $tag)
    {

        $ret.='<a style="font-size: '.$tag['weight'].'px;" href="/chefbot/kereses.php?id='.$tag['id'].'">'.$tag['tagname'].'</a>'."\n";


    }
    echo $ret;

    ?>
</div>
</body>
</html>
<?php

