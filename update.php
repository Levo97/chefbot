<?php
include_once 'include/menu.php'
?>
<p style="color: white">
    <?php
    $kategoriak=array();

    $hozzavalok=array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nev"])) {
            echo "<script>window.location.href = 'sajat.php';</script> ";
        } else {
            $nev = test_input($_POST["nev"]);
        }

        if (empty($_POST["egyeb"])) {
            echo "<script>window.location.href = 'sajat.php';</script> ";
        } else {
            $egyeb = test_input($_POST["egyeb"]);
        }



        if (empty($_POST["azonosito"])) {
            echo "<script>window.location.href = 'sajat.php';</script> ";
        } else {
            $azonosito = test_input($_POST["azonosito"]);
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $szekresztes=$_POST["szerkesztes"];
    $kategoriak =($_POST["kategoriak"]);

    $leiras = $_POST["szoveg"];

    $maxid = 0;






    for ($x=1; $x<=($azonosito); $x+=3){

        $mennyiseg=$_POST[$x+1];
        $mertek=$_POST[$x+2];


        if ($mertek=="dkg" || $mertek=="cl" ){
            $mennyiseg=$mennyiseg*10;

        }elseif ($mertek=="dl"){
            $mennyiseg=$mennyiseg*100;

        }
        elseif ($mertek=="kg" || $mertek=="l"){
            $mennyiseg=$mennyiseg*1000;

        }


        array_push($hozzavalok, array('hozzavalo_id'  =>$_POST[$x], 'mennyiseg' =>$mennyiseg));

    }


        $maxid=$_POST["szerkesztes"];
        $maxid = str_replace(' ', '', $maxid);

if (file_exists($_FILES['fileToUpload']['tmp_name']) || is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {

    $target_dir = "include/img/";
    $target_file = $target_dir . $maxid.".jpg";

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" ) {
        echo "Sorry, only JPG file is allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $uid=$_SESSION['id'];
                if (strlen($egyeb)<2){

                    $sql = "UPDATE recept SET neve = '$nev', leiras = '$leiras',missing_data = null WHERE id=$maxid;";

                }else{  $sql = "UPDATE recept SET neve = '$nev', leiras = '$leiras',missing_data = $egyeb WHERE id=$maxid;";}
                if ($conn->multi_query($sql) === TRUE) {
                    $sql = "delete from  hozzavalok where  recept_id=$maxid;";
                    $result = $conn->query($sql);
                    $sql = "delete from  kategoriak where  recept_id=$maxid;";
                    $result = $conn->query($sql);

                    foreach ($hozzavalok as $hozzavalo){
                        $sql = "INSERT INTO hozzavalok  (recept_id, alapanyag_id, mennyiseg)VALUES (".$maxid.",".$hozzavalo['hozzavalo_id'].",".$hozzavalo['mennyiseg'].")";
                        $result = $conn->query($sql);

                    }
                    for ($i=0; $i < (count($kategoriak)); $i++ ){
                        $sql = "INSERT INTO kategoriak  (kategoria_id, recept_id)VALUES (".$kategoriak[$i].",".$maxid." )";
                        $result = $conn->query($sql);
                    }
                }
            echo "<script>window.location.href = 'index.php';</script> ";
        } else {
            echo "Egy hiba volt a folyamatban";
        }
    }}else {
    $uid=$_SESSION['id'];
    if (strlen($egyeb)<2){

        $sql = "UPDATE recept SET neve = '$nev', leiras = '$leiras',missing_data = null WHERE id=$maxid;";

    }else{  $sql = "UPDATE recept SET neve = '$nev', leiras = '$leiras',missing_data = $egyeb WHERE id=$maxid;";}
    if ($conn->multi_query($sql) === TRUE) {
        $sql = "delete from  hozzavalok where  recept_id=$maxid;";
        $result = $conn->query($sql);
        $sql = "delete from  kategoriak where  recept_id=$maxid;";
        $result = $conn->query($sql);

        foreach ($hozzavalok as $hozzavalo){
            $sql = "INSERT INTO hozzavalok  (recept_id, alapanyag_id, mennyiseg)VALUES (".$maxid.",".$hozzavalo['hozzavalo_id'].",".$hozzavalo['mennyiseg'].")";
            $result = $conn->query($sql);

        }
        for ($i=0; $i < (count($kategoriak)); $i++ ){
            $sql = "INSERT INTO kategoriak  (kategoria_id, recept_id)VALUES (".$kategoriak[$i].",".$maxid." )";
            $result = $conn->query($sql);
        }
    }            echo "<script>window.location.href = 'index.php';</script> ";

}
    ?>
</p>
